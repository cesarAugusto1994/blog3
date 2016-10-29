/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    class BtnAdd extends React.Component{

        render() {
            return (
                React.createElement("a", {href: this.props.link, className: "button is-light is-small"}, "Adicionar Musica")
            );
        }

    }

    class BtnEditar extends React.Component{

        render() {
            return (
                React.createElement("a", {href: this.props.link, className: "button is-light is-small is-pulled-right"}, "Editar")
            );
        }

    }

    class BtnInativar extends React.Component{

        render() {
            return (
                React.createElement("a", {onClick: this.props.mudarStatus, className: "button is-danger is-outlined is-small is-pulled-right"}, "Inativar")
            );
        }
    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                React.createElement("a", {onClick: this.props.mudarStatus, className: "button is-success is-outlined is-small is-pulled-right"}, "Ativar")
            );
        }
    };

    class Card extends React.Component{
        render() {
            return (
                React.createElement("div", {className: "media wow fadeInUp animated slide", "data-wow-delay": ".3s"}, 
                    React.createElement("div", {className: "media-body"}, 
                        this.props.children
                    )
                )
            )
        }
    }

    var MudarStatusMusica = React.createClass({displayName: "MudarStatusMusica",

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

            var btn = React.createElement(BtnAtivar, {mudarStatus: this.handleMudarStatus});

            if (this.props.musica.ativo) {
                btn = React.createElement(BtnInativar, {mudarStatus: this.handleMudarStatus});
            }

            return (
                React.createElement("span", null, btn)
            )
        }

    });

    var ListMusicas = React.createClass({displayName: "ListMusicas",

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
                React.createElement("div", null, 
                    
                        _this.state.data.map(function (musica) {

                            var linkAnexos = "/user/musica/"+ musica.id +"/anexos";
                            var editarMusica = "/user/musicas/" + musica.id + "/" + musica.nome + "/editar";

                            return (
                                React.createElement(Card, {key: musica.id}, 
                                    React.createElement("h4", {className: "media-heading"}, React.createElement("a", {href: linkAnexos}, musica.nome), 
                                        React.createElement(BtnEditar, {link: editarMusica}), 
                                        React.createElement(MudarStatusMusica, {musica: musica, reloadMusica: _this.load})
                                    )
                                )
                            )
                        })
                    
                )
            )
        }
    });

    var View = React.createClass({displayName: "View",

        render : function () {

            var addMusica = '';

            if ("ROLE_ADMIN" == this.props.user) {
                addMusica = React.createElement(BtnAdd, {link: this.props.link})
            }

            return (
                React.createElement("div", null, 
                    addMusica, 
                    React.createElement("hr", {className: "small"}), 
                    React.createElement(ListMusicas, {source: this.props.source})
                )
            )
        }

    });



    var source = $("#musicas").attr("data-source");
    var sourceLink = $("#musicas").attr("data-add-musica");
    var user = $("#musicas").attr("data-user");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(View, {source: source, link: sourceLink, user: user})
        ),
            document.getElementById('musicas')
    );
});

