/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    const ROLE_ADMIN = "ROLE_ADMIN";

    class BtnAdd extends React.Component{

        render() {

            const url = "/user/praise/new?category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar Musica</a>
            );
        }

    }

    class BtnAdd2 extends React.Component{

        render() {

            const url = "/user/praise/new?various=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar V&aacute;rias Musica</a>
            );
        }

    }

    class BtnAdd3 extends React.Component{

        render() {

            const url = "/user/praise/new?various=1&same_category=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Adicionar V&aacute;rias Musica</a>
            );
        }

    }

    class BtnEditar extends React.Component{

        render() {
            return (
                <a href={this.props.link} className="button is-info is-inverted is-small">Editar</a>
            );
        }

    }

    class BtnInativar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-danger is-inverted is-small">Inativar</a>
            );
        }
    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-success is-inverted is-small">Ativar</a>
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

        render : function () {

            let btn = <BtnAtivar mudarStatus={this.handleMudarStatus} />;

            if (this.props.musica.ativo) {
                btn = <BtnInativar mudarStatus={this.handleMudarStatus} />;
            }

            return (
                <span>{btn}</span>
            )
        }

    });


    class BtnFavoritos extends React.Component {

        render() {

            let btn = (<a className="button is-small is-danger is-inverted add-remove"
                          onClick={this.props.handleFavoritos}
            >Remover dos Favoritos</a>);

            return (
                <span>{btn}</span>
            );
        }
    }

    const ListMusicas = React.createClass({

        handleFavoritos : function (e) {

            e.preventDefault();

            alert(e.target.musica);

            const _this = this;

            let id = this.props.musica;

            $("#add-remove").addClass("is-loading");

            block_screen(500);

            $.ajax({
                type: "POST",
                url: "/api/favoritos/add-remove",
                data: {
                    "id": id,
                },
                cache: false,
                success: function (data) {
                    $("#add-remove").removeClass("is-loading");
                    unblock_screen();
                    alertify.success(data.mensagem);
                    _this.loadFavoritos();
                },
                error: function () {
                    $("#add-remove").removeClass("is-loading");
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });
        },

        render : function () {

            let btnEditar = "";
            let btnMudarStatus = "";
            let btnRemoverDosFavoritos = "";
            const _this = this;

            return(
                <div>
                    {
                        this.props.data.map(function (favorito) {

                            let linkAnexos = "/user/praise/"+ favorito.musica.id + '-' + favorito.musica.nome.toLowerCase().replace(/ /g, '_');
                            let editarMusica = "/user/praises/" + favorito.musica.id + "-" + favorito.musica.nome.toLowerCase().replace(/ /g, '_') + "/edit";

                            if (ROLE_ADMIN == _this.props.user) {
                                btnEditar = <BtnEditar link={editarMusica}/>;
                                btnMudarStatus = <MudarStatusMusica musica={favorito.musica} reloadMusica={_this.props.reloadMusicas}/>;
                            }
/*
                            btnRemoverDosFavoritos = (
                                <BtnFavoritos musica={favorito.musica} handleFavoritos={_this.handleFavoritos}/>
                            );
*/
                            let musicaStr = favorito.musica.nome;

                            if (favorito.musica.numero) {
                                musicaStr = favorito.musica.numero + ' - ' + favorito.musica.nome;
                            }

                            return (
                                <div key={favorito.musica.id}>
                                    <h4 className="media-heading">
                                        <a href={linkAnexos}>{musicaStr} <span className="tag is-light is-pulled-right">{favorito.musica.qtde_anexos}</span></a>
                                    </h4>
                                    {btnRemoverDosFavoritos}
                                    {btnEditar}
                                    {btnMudarStatus}
                                    <hr/>
                                </div>
                            )
                        })
                    }
                </div>
            )
        }
    });

    const View = React.createClass({

        getInitialState : function () {
            return {data: []};
        },

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({data: result});
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        render : function () {
            return (
                <Base>
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

    const source = $("#favoritos").attr("data-source");
    const user = $("#favoritos").attr("data-user");

    if (document.getElementById("favoritos")) {
        ReactDOM.render(
            <div>
                <View source={source} user={user} />
            </div>,
            document.getElementById('favoritos')
        );
    }
});

