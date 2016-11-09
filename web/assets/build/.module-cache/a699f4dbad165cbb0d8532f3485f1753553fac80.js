/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    class BtnAdd extends React.Component{

        render() {

            return (
                React.createElement("a", {onClick: this.props.openModal, className: "button is-light is-small"}, "Adicionar Musica")
            );
        }

    }

    class BtnEditar extends React.Component{

        render() {
            return (
                React.createElement("a", {href: this.props.link, className: "button is-info is-inverted is-small is-pulled-right"}, "Editar")
            );
        }

    }

    class BtnInativar extends React.Component{

        render() {
            return (
                React.createElement("a", {onClick: this.props.mudarStatus, className: "button is-danger is-inverted is-small is-pulled-right"}, "Inativar")
            );
        }
    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                React.createElement("a", {onClick: this.props.mudarStatus, className: "button is-success is-inverted is-small is-pulled-right"}, "Ativar")
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

        render : function () {

            var btnEditar = "";
            var btnMudarStatus = "";
            var _this = this;

            return(
                React.createElement("div", null, 
                    
                        this.props.data.map(function (musica) {

                            var linkAnexos = "/user/musica/"+ musica.id +"/anexos";
                            var editarMusica = "/user/musicas/" + musica.id + "/" + musica.nome + "/editar";

                            if ("ROLE_ADMIN" == _this.props.user) {
                                btnEditar = React.createElement(BtnEditar, {link: editarMusica});
                                btnMudarStatus = React.createElement(MudarStatusMusica, {musica: musica, reloadMusica: _this.props.reloadMusicas});
                            }

                            return (
                                React.createElement("div", {key: musica.id}, 
                                    React.createElement("h4", {className: "media-heading"}, React.createElement("a", {href: linkAnexos}, musica.nome), 
                                        btnEditar, 
                                        btnMudarStatus
                                    ), React.createElement("hr", null)
                                )
                            )
                        })
                    
                )
            )
        }
    });

    var View = React.createClass({displayName: "View",

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

        openModal: function () {
            $("#musica-modal").modal("show");
        },

        closeModal: function () {
            $("#musica-modal").modal("hide");
        },

        render : function () {

            var addMusica = '';

            if ("ROLE_ADMIN" == this.props.user) {
                addMusica = React.createElement(BtnAdd, {openModal: this.openModal})
            }

            return (
                React.createElement("div", null, 
                    addMusica, 
                    React.createElement(GerenciarModal, {closeModal: this.closeModal, reloadMusicas: this.load, colecao: this.props.colecao, categoria: this.props.categoria}), 
                    React.createElement("hr", {className: "small"}), 
                    React.createElement(ListMusicas, {data: this.state.data, user: this.props.user, reloadMusicas: this.load})
                )
            )
        }

    });

    var Modal = React.createClass({displayName: "Modal",

        componentDidMount: function() {
            $(this.getDOMNode)
                .modal({backdrop: "static", keyboard: true, show: false});
        },

        componentWillUnmount: function() {
            $(this.getDOMNode)
                .off("hidden", this.handleHidden);
        },

        open: function() {
            $(this.getDOMNode).modal("show");
        },

        close: function() {
            $(this.getDOMNode).modal("hide");
        },

        render: function() {
            return (
                React.createElement("div", {id: "musica-modal", className: "modal fade", tabIndex: "-1"}, 
                    React.createElement("div", {className: "modal-dialog"}, 
                        React.createElement("div", {className: "modal-content"}, 
                            React.createElement("div", {className: "modal-header"}, 
                                React.createElement("button", {type: "button", className: "close", "data-dismiss": "modal"}, 
                                    React.createElement("span", null, "×")
                                ), 
                                React.createElement("h4", {className: "modal-title"}, this.props.title)
                            ), 
                            React.createElement("form", {className: "form-horizontal", onSubmit: this.props.handleSubmit}, 
                                React.createElement("div", {className: "modal-body"}, 
                                    this.props.children
                                ), 
                                React.createElement("div", {className: "modal-footer"}, 
                                    React.createElement("button", {type: "button", className: "button is-danger is-outlined is-pulled-left", "data-dismiss": "modal"}, "Cancelar"), 
                                    React.createElement("button", {type: "submit", className: "button is-success"}, "Salvar")
                                )
                            )
                        )
                    )
                )
            )
        }
    });

    var GerenciarModal = React.createClass({displayName: "GerenciarModal",

        getInitialState: function () {
            return {data: [], categorias : []}
        },

        load: function () {
            
            $.get('/user/tonalidades', function (result) {
                this.setState({data: result})
            }.bind(this));

            $.get('/user/categorias/' + colecao, function (result) {
                this.setState({categorias: result})
            }.bind(this));

        },

        componentDidMount: function () {
            this.load();
        },

        handleSubmit : function (e) {

            var _this = this;

            e.preventDefault();

            var nome = this.refs.nome.value.trim();
            var numero = this.refs.numero.value.trim();
            var tonalidade = this.refs.tonalidade.value.trim();
            var categoria = $("#musicas").data("categoria");

            if (!nome || !categoria) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "/user/musica/adicionar",
                data : {
                    nome : nome,
                    numero : numero,
                    tonalidade : tonalidade,
                    categoria : categoria
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadMusicas();
                    _this.props.closeModal();
                    unblock_screen();
                },
                error: function () {
                    alertify.error("ops, ocorreu um erro...");
                    unblock_screen();
                }
            });
        },

        render: function() {

            var modal = null;
            modal = (
                React.createElement(Modal, {title: "Adicionar Musica", handleSubmit: this.handleSubmit}, 
                    React.createElement("label", {htmlFor: "nome"}, "Nome"), 
                    React.createElement("input", {className: "input", type: "text", ref: "nome", name: "nome", ref: "nome", id: "nome", required: true}), 
                    React.createElement("label", {htmlFor: "numero"}, "Número"), 
                    React.createElement("input", {className: "input", type: "text", name: "numero", id: "numero", ref: "numero"}), 
                    React.createElement("label", {htmlFor: "tonalidade"}, "Tonalidade"), 
                    React.createElement("select", {className: "form-control", name: "tonalidade", ref: "tonalidade", id: "tonalidade"}, 
                        this.state.data.map(function (tom) {
                            return (
                                React.createElement("option", {key: tom}, tom)
                            )
                        })
                    )
                )
            );

            return (
                React.createElement("div", null, 
                    modal
                )
            );
        }
    });

    var source = $("#musicas").attr("data-source");
    var sourceLink = $("#musicas").attr("data-add-musica");
    var user = $("#musicas").attr("data-user");
    var colecao = $("#musicas").data("colecao");
    var categoria = $("#musicas").data("categoria");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(View, {source: source, link: sourceLink, user: user, colecao: colecao, categoria: categoria})
        ),
            document.getElementById('musicas')
    );
});

