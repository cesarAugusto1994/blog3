/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    class BtnAdd extends React.Component{

        render() {
            return (
                <a href={this.props.link} className="button is-light is-small">Adicionar Musica</a>
            );
        }

    }

    class BtnEditar extends React.Component{

        render() {
            return (
                <a href={this.props.link} className="button is-light is-small is-pulled-right">Editar</a>
            );
        }

    }

    class BtnInativar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-danger is-outlined is-small is-pulled-right">Inativar</a>
            );
        }
    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-success is-outlined is-small is-pulled-right">Ativar</a>
            );
        }
    };

    class Card extends React.Component{
        render() {
            return (
                <div className="media wow fadeInUp animated slide"  data-wow-delay=".3s">
                    <div className="media-body">
                        {this.props.children}
                    </div>
                </div>
            )
        }
    }

    var MudarStatusMusica = React.createClass({

        getInitialState : function () {
            return { ativo : this.props.musica.ativo }
        },

        loadStatus : function () {
            this.props.reloadMusica();
            this.setState({ ativo: !this.props.musica.ativo });
        },

        handleMudarStatus : function (e) {

            e.preventDefault();

            var _this = this;

            alertify.confirm("Deseja " + (this.state.ativo ? 'inativar' : 'ativar') + " esta musica?", function () {

                $.ajax({
                    type: 'POST',
                    url: '/user/musicas/' + _this.props.musica.id + '/status',
                    cache: false,
                    success: function (data) {
                        alertify.success(data.message);
                        unblock_screen();
                        _this.loadStatus();
                    },
                    error: function () {
                        unblock_screen();
                        alertify.error("Ocorreu um erro.");
                    }
                });

            }).setting("labels", {"ok": "Sim", "cancel": "Cancelar"});

        },

        render : function () {

            var btn = <BtnAtivar mudarStatus={this.handleMudarStatus} />;

            if (this.props.musica.ativo) {
                btn = <BtnInativar mudarStatus={this.handleMudarStatus} />;
            }

            return (
                <span>{btn}</span>
            )
        }

    });

    var ListMusicas = React.createClass({

        getInitialState : function () {
            return {data: []};
        },

        load : function () {
            var _this = this;
            $.get(_this.props.source, function (result) {
                this.setState({data: result});
            }.bind(_this))
        },  

        componentDidMount : function () {
            this.load();
        },

        render : function () {

            var _this = this;

            return(
                <div>
                    {
                        _this.state.data.map(function (musica) {

                            var linkAnexos = "/user/musica/"+ musica.id +"/anexos";
                            var editarMusica = "/user/musicas/" + musica.id + "/" + musica.nome + "/editar";

                            return (
                                <Card key={musica.id} >
                                    <h4 className="media-heading"><a href={linkAnexos}>{musica.nome}</a>
                                        <BtnEditar link={editarMusica}/>
                                        <MudarStatusMusica musica={musica} reloadMusica={_this.load}/>
                                    </h4>
                                </Card>
                            )
                        })
                    }
                </div>
            )
        }
    });

    var View = React.createClass({

        render : function () {

            var addMusica = '';

            if ("ROLE_ADMIN" == this.props.user) {
                addMusica = <BtnAdd link={this.props.link}/>
            }

            return (
                <div>
                    {addMusica}
                    <hr className="small" />
                    <ListMusicas source={this.props.source} />
                </div>
            )
        }

    });



    var source = $("#musicas").attr("data-source");
    var sourceLink = $("#musicas").attr("data-add-musica");
    var user = $("#musicas").attr("data-user");

    ReactDOM.render(
        <div>
            <View source={source} link={sourceLink} user={user} />
        </div>,
            document.getElementById('musicas')
    );
});

