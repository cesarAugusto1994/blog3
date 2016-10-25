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
                React.createElement("div", {id: "scheduleentry-modal", className: "modal fade", tabIndex: "-1"}, 
                    React.createElement("div", {className: "modal-dialog"}, 
                        React.createElement("div", {className: "modal-content"}, 
                            React.createElement("div", {className: "modal-header"}, 
                                React.createElement("button", {type: "button", className: "close", "data-dismiss": "modal"}, 
                                    React.createElement("span", null, "×")
                                ), 
                                React.createElement("h4", {className: "modal-title"}, this.props.title)
                            ), 
                            React.createElement("form", {className: "form-horizontal", ref: "uploadForm", onSubmit: this.props.handleSubmit}, 
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

    var UploadArquivo = React.createClass({displayName: "UploadArquivo",

        handleSubmit : function (e) {

            e.preventDefault();

            var _this = this;

            var id = this.refs.id.value.trim();
            var arquivo = this.refs.arquivo.value.trim();
            
            if(!arquivo) {
                alertify.error("Erro no arquivo.");
                return false;
            }
            
            var fd = new FormData();
            fd.append('files[]', this.refs.arquivo.files[0]);

            $("#btn-upload").addClass("is-loading");
            block_screen();

            $.ajax({
                type: "POST",
                url: "/user/musica/"+id+"/anexos/upload",
                enctype: "multipart/form-data",
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    unblock_screen();
                    _this.props.closeModal();
                },
                error: function (data) {
                    unblock_screen();
                    $("#btn-upload").removeClass("is-loading");
                    alertify.error(data.message);
                    _this.props.closeModal();
                }
            });

        },

        render: function() {

            var modal = null;
            modal = (
                React.createElement(Modal, {title: "Upload de Arquivos", handleSubmit: this.handleSubmit}, 
                    React.createElement("input", {type: "hidden", name: "musica", ref: "id", defaultValue: this.props.musica}), 
                    React.createElement("input", {className: "input", type: "file", ref: "arquivo", name: "files[]", id: "filer_input", multiple: "multiple"})
                )
            );

            return (
                React.createElement("div", {className: "scheduleentry-modal"}, 
                    modal
                )
            );
        }
    });

    var styleCard = { width: '100%' };
    var styleImg = {
        minWidth: '64px', maxWidth: '64px', minHeight: '64px', maxHeight: '64px', margin: 'auto'
    };

    var RemoverComentario = React.createClass({displayName: "RemoverComentario",

        handleRemoverComentario: function (e) {

        e.preventDefault();

        var _this = this;

        alertify.confirm("Deseja remover este Coment&aacute;rio?", function () {

            block_screen();

            $.ajax({
                type: 'POST',
                url: '/user/musica/anexos/comentario/'+ _this.props.comentario.id +'/remover',
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    unblock_screen();
                    _this.props.reloadComentarios();
                },
                error: function () {
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            })

        }).setting("labels", {"ok": "Sim", "cancel": "Cancelar"});
    },


        render : function () {

            return (
                React.createElement("a", {className: "button is-danger is-inverted is-small", onClick: this.handleRemoverComentario, "data-comentario": this.props.comentario}, "Inativar")
            )
        }
    });

    var CardComentarios = React.createClass({displayName: "CardComentarios",

        render: function () {
            return (
                React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: styleCard}, 
                    React.createElement("div", {className: "card-content"}, 
                        React.createElement("p", {className: "title is-3"}, "Comentários"), 
                        React.createElement("div", {className: "comments"}, 
                            this.props.children
                        )
                    )
                )
            );
        }

    });

    var ListComentarios = React.createClass({displayName: "ListComentarios",

        render: function () {

            var _this = this;

            return (
                React.createElement("div", null, 
                    this.props.data.map(function (comentario) {

                        var img = _this.props.dirAvatar + comentario.usuario.avatar;

                        return (
                            React.createElement("div", {key: comentario.id}, 
                                React.createElement("div", {className: "media"}, 
                                    React.createElement(ImageComentario, {avatar: img}), 
                                    React.createElement("div", {className: "media-body"}, 
                                        React.createElement("h4", {className: "media-heading"}, comentario.usuario.nome, 
                                            React.createElement(RemoverComentario, {comentario: comentario, reloadComentarios: _this.props.reloadComentarios}), 
                                            React.createElement("a", {className: "button is-light is-small is-pulled-right"}, comentario.cadastro)
                                        ), 
                                        React.createElement("p", null, 
                                            comentario.comentario
                                        )
                                    )
                                ), 
                                React.createElement("br", null)
                            )
                        )
                    })
                )
            );
        }
    });

    var ImageComentario = React.createClass({displayName: "ImageComentario",

        render : function () {
            return (
                React.createElement("a", {className: "pull-left"}, 
                    React.createElement("img", {style: styleImg, 
                         alt: "", 
                         src: this.props.avatar, 
                         className: "media-object"})
                )
            );
        }
    });

    var FormComentario = React.createClass({displayName: "FormComentario",

        handleSubmit : function (e) {

            e.preventDefault();

            var id = this.refs.id.value.trim();
            var comentario = this.refs.comentario.value.trim();

            var _this = this;

            if (!comentario) {
                alertify.error('Deve informar um comentario');
                _this.refs.comentario.focus();
                return false;
            }

            $("#comentar").addClass("is-loading");

            $.ajax({
                type: "POST",
                url: "/user/musica/"+id+"/anexos/comentar",
                data : {
                    "id" : id,
                    "comentario" : comentario
                },
                cache: false,
                success: function (data) {
                    $("#comentar").removeClass("is-loading");
                    unblock_screen();
                    _this.refs.comentario.value = '';
                    _this.props.reloadComentarios();
                },
                error: function () {
                    $("#comentar").removeClass("is-loading");
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });


        },

        render : function () {

            return (
                React.createElement("div", {className: "post-comment"}, 
                    React.createElement("form", {className: "form-horizontal"}, 
                        React.createElement("input", {type: "hidden", name: "musica_id", id: "musica_id", ref: "id", defaultValue: this.props.musicaId}), 
                            React.createElement("div", {className: "form-group"}, 
                                React.createElement("div", {className: "col-lg-12"}, 
                                    React.createElement("textarea", {className: " form-control", name: "comentario", id: "comentario", ref: "comentario", rows: "3", placeholder: "Comentar"})
                                )
                            ), 
                            React.createElement("p", null, 
                                React.createElement("button", {id: "comentar", ref: "submit", className: "button is-danger", onClick: this.handleSubmit}, "Comentar")
                            )
                    )
                )
            );
        }
    });

    var ViewCometarios = React.createClass({displayName: "ViewCometarios",

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            var _this = this;
            $.get(_this.props.source, function (result) {
                _this.setState({data: result});
            }.bind(_this));
        },
        componentDidMount: function () {
            this.load();
        },

        render : function () {
            return (
                React.createElement("div", null, 
                    React.createElement(CardComentarios, null, 
                        React.createElement(ListComentarios, {data: this.state.data, dirAvatar: this.props.dirAvatar, reloadComentarios: this.load}), 
                        React.createElement(FormComentario, {musicaId: this.props.musicaId, reloadComentarios: this.load})
                    )
                )
            )
        }
    });

    var ListArquivos = React.createClass({displayName: "ListArquivos",

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            var _this = this;
            $.get(_this.props.sourceArquivos, function (result) {
                _this.setState({data: result});
            }.bind(_this));
        },
        componentDidMount: function () {
            this.load();
        },
        
        render : function () {
            return (
                React.createElement("div", null, 
                    this.state.data.map(function (anexo) {
                        
                        return (
                            React.createElement("div", {key: anexo.id}, 
                                React.createElement("div", {className: "media"}, 
                                    React.createElement("div", {className: "media-body"}, 
                                        React.createElement("h4", {className: "media-heading"}, anexo.nome, 
                                            React.createElement("a", {className: "button is-light is-small is-pulled-right"}, anexo.cadastro)
                                        ), 
                                        React.createElement("p", null, 
                                            comentario.comentario
                                        )
                                    )
                                ), 
                                React.createElement("br", null)
                            )
                        )
                    })
                )
            );   
        }

    });

    var ViewArquivos = React.createClass({displayName: "ViewArquivos",

        getInitialState: function() {
            return { isModalOpen: false };
        },

        openModal: function() {
            this.setState({ isModalOpen: true });
        },

        closeModal: function() {
            this.setState({ isModalOpen: false });
        },
        render: function () {

            return (
                React.createElement("div", null, 
                React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: styleCard}, 
                    React.createElement("div", {className: "card-content"}, 
                        React.createElement("div", {className: "media"}, 
                            React.createElement("div", {className: "media-content"}, 
                                React.createElement("button", {"data-toggle": "modal", "data-target": "#scheduleentry-modal", onClick: this.openModal, className: "button is-danger is-inverted is-small"}, "Adicionar Arquivo"), 
                                React.createElement(ListArquivos, {sourceArquivos: this.props.sourceArquivos})
                            )
                        )
                    )
                ), 
                    React.createElement(UploadArquivo, {closeModal: this.closeModal, musica: this.props.musica})
                )
            );
        }
    });

    var source = $("#comentarios").attr("data-source");
    var sourceArquivos = $("#comentarios").attr("data-source-arquivos");
    var musicaId = $("#comentarios").attr("data-musica-id");
    var user = $("#comentarios").attr("data-user");
    var dirAvatar = $("#comentarios").attr("data-dir-avatar");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(ViewArquivos, {sourceArquivos: sourceArquivos, musica: musicaId}), 
            React.createElement(ViewCometarios, {source: source, user: user, dirAvatar: dirAvatar, musicaId: musicaId})
        ),
        document.getElementById('comentarios')
    );
});