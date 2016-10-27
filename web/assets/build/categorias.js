/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var divStyle = {
        width: '100%'
    };

    class BtnEditar extends React.Component {

        render() {

            return (
                React.createElement("a", {className: "button is-white is-pulled-right is-small", 
                   onClick:  this.props.acao, 
                   "data-id":  this.props.categoria.id, 
                   "data-nome":  this.props.categoria.nome, 
                   "data-colecao":  this.props.categoria.colecao.id}, "Editar")
            )
        }

    };

    class BtnInativar extends React.Component{

        render() {
            return (
                React.createElement("a", {className: "button is-danger is-inverted is-pulled-right is-small mudarStatus", onClick: this.props.acao, "data-categoria":  this.props.categoria.id}, "Inativar")
            )
        }

    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                React.createElement("a", {className: "button is-success is-inverted is-pulled-right is-small mudarStatus", onClick: this.props.acao, "data-categoria":  this.props.categoria.id}, "Ativar")
            )
        }

    };

    class BtnAddCategoria extends React.Component{
        render() {
            return (
                React.createElement("button", {onClick: this.props.openModal, className: "button is-light is-small"}, "Nova Categoria")
            );
        }
    };

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
                React.createElement("div", {id: "scheduleentry-modal", className: "modal fade", tabIndex: "-1"}, 
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

    var EditarCategoriaModal = React.createClass({displayName: "EditarCategoriaModal",

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get('/user/colecoes/all', function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            this.load();
        },
        
        handleSubmit : function (e) {
          
            e.preventDefault();

            var id = this.refs.id.value.trim();
            var nome = this.refs.nome.value.trim();
            var colecao = this.refs.colecao.value.trim();

            if (!nome || !colecao) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
            }

            $.ajax({
                type: "POST",
                url: "/user/categoria/"+id+"/editar",
                data : {
                    id : id,
                    nome : nome,
                    colecao : colecao
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    unblock_screen();
                },
                error: function () {
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });
        },
        
        render: function() {

            var modal = null;
            modal = (
                React.createElement(Modal, {title: "Categoria", handleSubmit: this.handleSubmit}, 
                    React.createElement("input", {type: "hidden", ref: "id", name: "id", id: "id", defaultValue: this.props.categoria.id}), 
                    React.createElement("label", {htmlFor: "nome"}, "Nome"), 
                    React.createElement("input", {className: "input is-primary", type: "text", placeholder: "Nome", defaultValue: this.props.categoria.nome, ref: "nome", name: "nome", id: "nome", required: true}), 
                    React.createElement("label", {htmlFor: "colecao"}, "Coleção"), 
                    React.createElement("select", {className: "input is-primary", ref: "colecao", name: "colecao", id: "colecao", value: this.props.categoria.colecao.id}, 
                         this.state.data.map(function (colecao) {
                            return (
                                React.createElement("option", {key: colecao.id, value: colecao.id}, colecao.nome)
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

    var NovaCategoriaModal = React.createClass({displayName: "NovaCategoriaModal",

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get('/user/colecoes/all', function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            this.load();
        },

        handleSubmit : function (e) {

            e.preventDefault();

            var nome = this.refs.nome.value.trim();
            var colecao = this.refs.colecao.value.trim();

            if (!nome || !colecao) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
            }

            var _this = this;

            $.ajax({
                type: "POST",
                url: "/user/categoria/adicionar",
                data : {
                    nome : nome,
                    colecao : colecao
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    unblock_screen();
                    _this.props.closeModal();
                    _this.props.reloadCategoria();
                },
                error: function () {
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });
        },

        render: function() {

            var modal = null;
            modal = (
                React.createElement(Modal, {title: "Categoria", handleSubmit: this.handleSubmit}, 
                    React.createElement("label", {htmlFor: "nome"}, "Nome"), 
                    React.createElement("input", {className: "input is-primary", type: "text", placeholder: "Nome", ref: "nome", name: "nome", id: "nome", required: true}), 
                    React.createElement("label", {htmlFor: "colecao"}, "Coleção"), 
                    React.createElement("select", {className: "input is-primary", ref: "colecao", name: "colecao", id: "colecao"}, 
                         this.state.data.map(function (colecao) {
                            return (
                                React.createElement("option", {key: colecao.id, value: colecao.id}, colecao.nome)
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

    var BlockCategorias = React.createClass({displayName: "BlockCategorias",

        render: function () {

            var mudarStatus = '';
            var editar = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = React.createElement(MudarStatusCategoria, {categoria: this.props.categoria, reloadCategoria: this.props.reloadCategoria})
                editar = React.createElement(BtnEditar, {categoria: this.props.categoria, acao: this.props.acao})
            }

            return (
                React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: divStyle}, 
                    React.createElement("div", {className: "card-content"}, 
                        React.createElement("div", {className: "media"}, 
                            React.createElement("div", {className: "media-body"}, 
                                React.createElement("h4", {className: "media-heading"}, 
                                    React.createElement("a", {href: this.props.musicasUrl}, this.props.categoria.nome), 
                                    editar, 
                                    mudarStatus
                                )
                            )
                        )
                    )
                )
            )
        }
    });

    var MudarStatusCategoria = React.createClass({displayName: "MudarStatusCategoria",

        loadStatus : function() {
            this.props.reloadCategoria();
            this.setState({ ativo: !this.props.categoria.ativo });
        },

        getInitialState: function() {
            return { ativo: this.props.categoria.ativo }
        },

        handleInativarCategoria: function (e) {

            e.preventDefault();

            var _this = this;
            var categoria = this.props;

            alertify.confirm("Deseja " + (this.state.ativo ? 'Inativar' : 'Ativar') + " esta Categoria?", function () {

                block_screen();

                $.ajax({
                    type: 'POST',
                    url: '/user/categoria/' + categoria.categoria.id + '/status',
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
                })

            }).setting("labels", {"ok": "Sim", "cancel": "Cancelar"});
        },
        render: function () {

            var btnStatus = '';

            if (this.state.ativo) {
                btnStatus = React.createElement(BtnInativar, {acao: this.handleInativarCategoria, categoria: this.props.categoria});
            } else {
                btnStatus = React.createElement(BtnAtivar, {acao: this.handleInativarCategoria, categoria: this.props.categoria})
            }

            return (
                React.createElement("e", null, btnStatus)
            )
        }

    });

    var CategoriasList = React.createClass({displayName: "CategoriasList",

        render: function () {

            var _this = this;

            return (
                React.createElement("div", null, 
                React.createElement("span", null,  _this.props.categoria.map(function (categoria) {
                    var musicasUrl = "/user/musicas/" + categoria.id;
                    return (
                        React.createElement("div", {key: categoria.id}, 
                            React.createElement(BlockCategorias, {categoria: categoria, musicasUrl: musicasUrl, user: _this.props.user, reloadCategoria: _this.props.reloadCategoria, acao: _this.props.acao}), 
                            React.createElement(EditarCategoriaModal, {categoria: categoria})
                        )
                    )
                }) )

                )
            )
        }
    });

    var OpcoesList = React.createClass({displayName: "OpcoesList",

        render : function () {
            return (
                React.createElement("div", null, 
                    React.createElement(BtnAddCategoria, {openModal: this.props.acao}), 
                    React.createElement(NovaCategoriaModal, {reloadCategoria: this.props.reloadCategoria, closeModal: this.props.closeModal}), 
                    React.createElement("hr", {className: "small"})
                )
            );
        }

    });

    var View = React.createClass({displayName: "View",

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            var _this = this;
            $.get(_this.props.source, function (result) {
                _this.setState({ data: result });
            }.bind(_this));
        },
        componentDidMount: function() {
            this.load();
        },
        openModal: function () {
            $("#scheduleentry-modal").modal("show");
        },
        closeModal: function () {
            $("#scheduleentry-modal").modal("hide");
            $('.modal-body #id').val('');
            $('.modal-body #nome').val('');
            $('.modal-body #colecao').val('');
        },

        render : function () {

            var opcoes = '';

            if (this.props.user == 'ROLE_ADMIN') {
                opcoes = React.createElement(OpcoesList, {reloadCategoria: this.load, acao: this.openModal, closeModal: this.closeModal})
            }

            return (
                React.createElement("div", null, 
                    opcoes, 
                    React.createElement(CategoriasList, {categoria: this.state.data, source: this.props.source, user: this.props.user, reloadCategoria: this.load, acao: this.openModal})
                )
            );
        }
    });

    var source = $("#categorias").attr("data-source");
    var user = $("#categorias").attr("data-user");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(View, {source: source, user: user})
        ),
        document.getElementById('categorias')
    );


});