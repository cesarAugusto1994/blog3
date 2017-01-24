/**
 * Created by cesar on 20/10/16.
 */

$(function () {

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
                React.createElement("div", {id: "album-modal", className: "modal fade", tabIndex: "-1"}, 
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

        getInitialState : function () {
           return {data : []} 
        }, 

        load : function () {
            $.get('/user/todas-categorias', function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        
        componentDidMount : function () {
            this.load();
        },

        handleSubmit : function (e) {

            var _this = this;

            e.preventDefault();

            var nome = this.refs.nome.value.trim();
            var categoria = this.refs.categoria.value.trim();

            var fd = new FormData();
            fd.append('nome', nome);
            fd.append('categoria', categoria);

            if (!nome) {
                alertify.error("O Nome deve ser informado.");
                return false;
            }

            var img = this.refs.imagem.files;
            $.each(img, function (index, value) {
                fd.append('img[]', img[index]);
            });

            var files = this.refs.musicas.files;
            $.each(files, function (index, value) {
                fd.append('files[]', files[index]);
            });

            $.ajax({
                type: "POST",
                url: "/user/albuns/adicionar",
                data : fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadAlbuns();
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
                React.createElement(Modal, {title: "Adicionar Album", handleSubmit: this.handleSubmit}, 
                    React.createElement("label", {htmlFor: "nome"}, "Nome"), 
                    React.createElement("input", {className: "input", type: "text", ref: "nome", name: "nome", ref: "nome", id: "nome", required: true}), 
                    React.createElement("label", {htmlFor: "imagem"}, "Imagem"), 
                    React.createElement("input", {className: "input", type: "file", name: "imagem", id: "imagem", ref: "imagem"}), 
                    React.createElement("label", {htmlFor: "categoria"}, "Categoria"), 
                    React.createElement("select", {className: "form-control", name: "categoria", ref: "categoria", id: "categoria"}, 
                        React.createElement("option", {value: ""}, "Sem Categoria"), 
                        this.state.data.map(function (categoria) {
                            return (
                                React.createElement("option", {key: categoria.id, value: categoria.id}, categoria.nome)
                            )
                        })
                    ), 
                    React.createElement("label", {htmlFor: "musicas"}, "Musicas"), 
                    React.createElement("input", {className: "input", type: "file", multiple: true, name: "musicas", id: "musicas", ref: "musicas"})
                )
            );

            return (
                React.createElement("div", null, 
                    modal
                )
            );
        }
    });

    var divStyle = {
        minHeight: '130px',
        maxHeight: '130px',
        margin: 'auto'
    };

    class BtnEditar extends React.Component {

        render() {
            return (
                React.createElement("a", {className: "button is-light is-pulled-right is-small openMenu", 
                   "data-toggle": "modal", 
                   "data-target": "#myModal", 
                   "data-id":  this.props.album.id, 
                   "data-nome":  this.props.album.label}, "Editar")
            )
        }

    };

    class Image extends React.Component{
        render() {
            return (
                React.createElement("a", null, 
                    React.createElement("img", {className: "img-responsive img-rounded", style: divStyle, src: this.props.album.imagem ? this.props.dirImg + this.props.album.imagem : this.props.defaultImage, alt: this.props.album.label})
                )
            )
        }
    };

    class Figure extends React.Component{

        render() {

            var editar = '';

            if (this.props.user == 'ROLE_ADMIN') {
                editar = React.createElement(BtnEditar, {album: this.props.album})
            }

            return (
                React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                    React.createElement("div", {className: "img-wrapper"}, 
                        React.createElement(Image, {album: this.props.album, dirImg: this.props.dirImg, defaultImage: this.props.defaultImage})
                    ), 
                    React.createElement("figcaption", null, 
                        React.createElement("h4", null, 
                            React.createElement("a", null, 
                                this.props.album.label
                            )
                        )
                    )
                )
            )
        }
    };

    class BlockColecoes extends React.Component{

        render() {

            return (
                React.createElement("div", {className: "col-sm-4 col-xs-12"}, 
                    React.createElement(Figure, {album: this.props.album, dirImg: this.props.dirImg, 
                            defaultImage: this.props.defaultImage, reloadColecao: this.props.reloadColecao, user: this.props.user})
                )
            )
        }
    };

    var AlbunsList = React.createClass({displayName: "AlbunsList",

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            this.load();
        },

        openModal: function () {
            $("#album-modal").modal("show");
        },

        closeModal: function () {
            $("#album-modal").modal("hide");
        },

        render: function () {
            return (
                React.createElement("div", null, 

                    React.createElement("button", {onClick: this.openModal, className: "button is-primary is-small"}, "Adicionar Album"), 
                    React.createElement("hr", {className: "small"}), 
                    React.createElement(GerenciarModal, {reloadAlbuns: this.load, closeModal: this.closeModal}), 

                     this.state.data.map(function (album) {
                    return (
                        React.createElement("div", {key: album.id}, 
                            React.createElement(BlockColecoes, {album: album, 
                                           dirImg: dirImg, 
                                           defaultImage: defaultImage, 
                                           reloadColecao: this.load, 
                                           user: user}
                            )
                        )
                    )
                }) )
            )
        }
    });

    var source = $("#albuns").attr("data-source");
    var dirImg = $("#albuns").attr("data-img");
    var defaultImage = $("#albuns").attr("data-defaul-image");
    var user = $("#albuns").attr("data-user");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(AlbunsList, {source: source, dirImg: dirImg, defaultImage: defaultImage, user: user})
        ),
        document.getElementById('albuns')
    );


});