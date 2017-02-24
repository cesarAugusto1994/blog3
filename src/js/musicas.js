/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    const ROLE_ADMIN = "ROLE_ADMIN";

    class BtnAdd extends React.Component {

        render() {

            const url = "/user/praise/new?category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar Musica</a>
            );
        }

    }

    class BtnAdd2 extends React.Component {

        render() {

            const url = "/user/praise/new?various=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar V&aacute;rias Musica</a>
            );
        }

    }

    class BtnAdd3 extends React.Component {

        render() {

            const url = "/user/praise/new?various=1&same_category=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar V&aacute;rias Musica</a>
            );
        }

    }

    class BtnEditar extends React.Component {

        render() {
            return (
                <a href={this.props.link} className="button is-info is-inverted is-small">Editar</a>
            );
        }

    }

    class BtnInativar extends React.Component {

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-danger is-inverted is-small">Inativar</a>
            );
        }
    }
    ;

    class BtnAtivar extends React.Component {

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-success is-inverted is-small">Ativar</a>
            );
        }
    }
    ;

    class Card extends React.Component {
        render() {
            return (
                <div className="media wow fadeInUp animated slide" data-wow-delay=".3s">
                    <div className="media-body">
                        {this.props.children}
                    </div>
                </div>
            )
        }
    }

    var MudarStatusMusica = React.createClass({

        getInitialState: function () {
            return {ativo: this.props.musica.ativo}
        },

        loadStatus: function () {
            this.props.reloadMusica();
            this.setState({ativo: !this.props.musica.ativo});
        },

        handleMudarStatus: function (e) {

            e.preventDefault();

            const _this = this;

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

        render: function () {

            let btn = <BtnAtivar mudarStatus={this.handleMudarStatus}/>;

            if (this.props.musica.ativo) {
                btn = <BtnInativar mudarStatus={this.handleMudarStatus}/>;
            }

            return (
                <span>{btn}</span>
            )
        }

    });

    var ListMusicas = React.createClass({

        render: function () {

            let btnEditar = "";
            let btnMudarStatus = "";
            let btnRegistros = "";
            let btns = "";

            const _this = this;

            return (
                <div>
                    {
                        this.props.data.map(function (musica) {

                            let linkAnexos = "/user/praise/" + musica.id + '-' + musica.nome.toLowerCase().replace(/ /g, '_') + "/attachments";
                            let editarMusica = "/user/praises/" + musica.id + "-" + musica.nome.toLowerCase().replace(/ /g, '_') + "/edit";

                            if (ROLE_ADMIN == _this.props.user) {
                                btnEditar = <BtnEditar link={editarMusica}/>;
                                btnMudarStatus = <MudarStatusMusica musica={musica} reloadMusica={_this.props.reloadMusicas}/>;
                                btnRegistros = <span className="tag is-light">{musica.qtde_anexos}</span>

                                btns = (
                                    <div className="control is-grouped is-centered">
                                        <p className="control">
                                            <MudarStatusMusica musica={musica} reloadMusica={_this.props.reloadMusicas}/>
                                        </p>
                                        <p className="control">
                                            <BtnEditar link={editarMusica}/>
                                        </p>
                                        <p className="control">
                                            <span className="tag is-light">{musica.qtde_anexos}</span>
                                        </p>
                                    </div>
                                );

                            }

                            let musicaStr = musica.nome;

                            if (musica.numero) {
                                musicaStr = musica.numero + ' - ' + musica.nome;
                            }

                            return (
                                <div key={musica.id}>
                                    <div className="wow fadeInLeft animated portfolio-item">
                                        <div className="col-sm-12 col-xs-12">
                                            <h4 className="tile">
                                                <a href={linkAnexos}>
                                                    {musicaStr}
                                                </a>
                                            </h4>
                                            {btns}
                                        </div>
                                    </div>
                                </div>
                            )
                        })
                    }
                </div>
            )
        }
    });

    var View = React.createClass({

        getInitialState: function () {
            return {data: []};
        },

        load: function () {
            $.get(this.props.source, function (result) {
                this.setState({data: result});
            }.bind(this))
        },

        componentDidMount: function () {
            this.load();
        },

        openModal: function () {
            $("#musica-modal").modal("show");
        },

        closeModal: function () {
            $("#musica-modal").modal("hide");
        },

        render: function () {

            let addMusica = (<BtnAdd categoria={this.props.categoria} categoriaNome={this.props.categoriaNome}/>);
            let addMusica2 = '';
            let addMusica3 = '';

            if (ROLE_ADMIN == this.props.user) {
                addMusica2 = <BtnAdd2 categoria={this.props.categoria} categoriaNome={this.props.categoriaNome}/>;
                addMusica3 = <BtnAdd3 categoria={this.props.categoria} categoriaNome={this.props.categoriaNome}/>;
            }

            return (
                <Base>
                    {addMusica}
                    {addMusica2}
                    {addMusica3}
                    <hr className="small"/>
                    <ListMusicas data={this.state.data} user={this.props.user} reloadMusicas={this.load}/>
                </Base>
            )
        }

    });

    class Base extends React.Component {
        render() {
            return (
                <article>
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                                {this.props.children}
                            </div>
                        </div>
                    </div>
                </article>
            )
        }
    }

    var source = $("#musicas").attr("data-source");
    var sourceLink = $("#musicas").attr("data-add-musica");
    var user = $("#musicas").attr("data-user");
    var colecao = $("#musicas").data("colecao");
    var categoria = $("#musicas").data("categoria");
    var categoriaNome = $("#musicas").data("categoria-nome");

    if (document.getElementById("musicas")) {
        ReactDOM.render(
            <div>
                <View source={source} link={sourceLink} user={user} colecao={colecao} categoria={categoria}
                      categoriaNome={categoriaNome}/>
            </div>,
            document.getElementById('musicas')
        );
    }
});

