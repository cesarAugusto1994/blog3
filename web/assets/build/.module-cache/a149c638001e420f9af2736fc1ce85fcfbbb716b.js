/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var divStyle = {
        width: '100%'
    };

    class BtnEditar extends React.Component {

        render() {
            console.log(this.props);

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
                            React.createElement("div", {className: "modal-body"}, 
                                this.props.children
                            ), 
                            React.createElement("div", {className: "modal-footer"}, 
                                React.createElement("button", {type: "button", className: "btn btn-danger pull-left", "data-dismiss": "modal"}, "Delete"), 
                                React.createElement("button", {type: "button", className: "btn btn-primary"}, "Save")
                            )
                        )
                    )
                )

            )
        }
    });

    var SelectColecoes = React.createClass({displayName: "SelectColecoes",

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            var _this = this;
            $.get('/user/colecoes', function (result) {
                _this.setState({ data: result });
            }.bind(_this));
        },
        componentDidMount: function() {
            this.load();
        },

        render: function () {
            return (
                React.createElement("span", null, 
                    React.createElement("select", {className: "input is-primary"}, 
                         _this.state.data.map(function (colecao) {
                            React.createElement("option", {value: colecao.nome}, colecao.nome)
                        })
                    )
                )
            )
        }

    });

    var ScheduleEntryModal = React.createClass({displayName: "ScheduleEntryModal",
        render: function() {
            var modal = null;
            modal = (
                React.createElement(Modal, {title: "Add Schedule Entry"}, 
                    React.createElement("form", {className: "form-horizontal"}, 

                        React.createElement("input", {type: "hidden", ref: "id", name: "id", id: "id"}), 

                        React.createElement("label", {htmlFor: "nome"}, "Nome"), 
                        React.createElement("input", {className: "input is-primary", type: "text", placeholder: "Nome", ref: "nome", name: "nome", 
                               id: "nome", required: true}), 
                        React.createElement("label", {htmlFor: "colecao"}, "Coleção"), 
                        React.createElement(SelectColecoes, null)

                    )
                )
            );

            return (
                React.createElement("div", {className: "scheduleentry-modal"}, 
                    modal
                )
            );
        }
    });

    var BlockCategorias = React.createClass({displayName: "BlockCategorias",

        render: function () {

            console.log(this.props);

            var mudarStatus = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = React.createElement(MudarStatusCategoria, {categoria: this.props.categoria, reloadCategoria: this.props.reloadCategoria})
            }

            return (
                React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: divStyle}, 
                    React.createElement("div", {className: "card-content"}, 
                        React.createElement("div", {className: "media"}, 
                            React.createElement("div", {className: "media-body"}, 
                                React.createElement("h4", {className: "media-heading"}, 
                                    React.createElement("a", {href: this.props.musicasUrl}, this.props.categoria.nome), 
                                    React.createElement(BtnEditar, {categoria: this.props.categoria, acao: this.props.acao}), 
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
                React.createElement("i", null, btnStatus)
            )
        }

    });

    var CategoriasList = React.createClass({displayName: "CategoriasList",
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

        render: function () {

            var _this = this;

            return (
                React.createElement("div", null, 
                React.createElement("span", null,  this.state.data.map(function (categoria) {
                    var musicasUrl = "/user/musicas/" + categoria.id + "/" + categoria.nome;
                    return (
                        React.createElement("div", {key: categoria.id}, 
                            React.createElement(BlockCategorias, {categoria: categoria, musicasUrl: musicasUrl, user: user, reloadCategoria: _this.load, acao: _this.openModal})
                        )
                    )
                }) ), 
                    React.createElement(ScheduleEntryModal, null)
                )
            )
        }
    });

    var source = $("#categorias").attr("data-source");
    var user = $("#categorias").attr("data-user");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(CategoriasList, {source: source, user: user})
        ),
        document.getElementById('categorias')
    );

    $(document).on('click', '.openMenu', function () {
        $('.modal-body #id').val($(this).data('id'));
        $('.modal-body #nome').val($(this).data('nome'));
        $('.modal-body #colecao').val($(this).data('colecao'));
        $('.modal-body #colecao').attr('selected', selected);
    });

    $(document).on('click', '.addCategoria', function () {
        $('.modal-body #id').val('');
        $('.modal-body #nome').val('');
        $('.modal-body #colecao').val('');
    });


});