/**
 * Created by cesar on 20/10/16.
 */

$(function () {

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
                    alertify.success(data.message);
                    _this.props.reloadArquivos();
                    _this.props.closeModal();
                    unblock_screen();
                },
                error: function (data) {
                    unblock_screen();
                    $("#btn-upload").removeClass("is-loading");
                    alertify.error(data.message);
                }
            });

        },

        render: function() {

            var modal = null;
            modal = (
                React.createElement("div", {id: "modal-musicas", className: "modal fade", tabIndex: "-1"}, 
                    React.createElement("div", {className: "modal-dialog"}, 
                        React.createElement("div", {className: "modal-content"}, 
                            React.createElement("div", {className: "modal-header"}, 
                                React.createElement("button", {type: "button", className: "close", "data-dismiss": "modal"}, 
                                    React.createElement("span", null, "×")
                                ), 
                                React.createElement("h4", {className: "modal-title"}, this.props.title)
                            ), 
                            React.createElement("form", {className: "form-horizontal", ref: "uploadForm", onSubmit: this.handleSubmit}, 
                                React.createElement("div", {className: "modal-body"}, 
                                    React.createElement("input", {type: "hidden", name: "musica", ref: "id", defaultValue: this.props.musica}), 
                                    React.createElement("input", {className: "input", type: "file", ref: "arquivo", name: "files[]", id: "filer_input", multiple: "multiple", 
                                           accept: "image/gif, image/jpeg, image/png, image/jpg, audio/mpeg, audio/mp3, application/octet-stream, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"})
                                ), 
                                React.createElement("div", {className: "modal-footer"}, 
                                    React.createElement("button", {type: "button", className: "button is-danger is-outlined is-pulled-left", "data-dismiss": "modal"}, "Cancelar"), 
                                    React.createElement("button", {type: "submit", className: "button is-success"}, "Salvar")
                                )
                            )
                        )
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

    var AddLink = React.createClass({displayName: "AddLink",

        handleSubmit : function (e) {

            e.preventDefault();

            var _this = this;

            var id = this.refs.musica.value.trim();
            var tipo = this.refs.tipo.value.trim();
            var link = this.refs.link.value.trim();

            if(!link) {
                alertify.error("Erro no arquivo.");
                return false;
            }

            $("#btn-upload").addClass("is-loading");
            block_screen();

            $.ajax({
                type: "POST",
                url: "/user/musica/"+id+"/anexos/save",
                data: {
                    id : id,
                    tipo : tipo,
                    link : link
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadArquivos();
                    _this.props.closeModal();
                    unblock_screen();
                },
                error: function (data) {
                    unblock_screen();
                    $("#btn-upload").removeClass("is-loading");
                    alertify.error(data.message);
                }
            });

        },

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            $.get('/user/tipos/anexos', function (result) {
                this.setState({data: result});
            }.bind(this));
        },
        componentDidMount: function () {
            this.load();
        },

        render: function() {

            var modal = null;
            modal = (
                React.createElement("div", {id: "modal-add-link", className: "modal fade", tabIndex: "-1"}, 
                    React.createElement("div", {className: "modal-dialog"}, 
                        React.createElement("div", {className: "modal-content"}, 
                            React.createElement("div", {className: "modal-header"}, 
                                React.createElement("button", {type: "button", className: "close", "data-dismiss": "modal"}, 
                                    React.createElement("span", null, "×")
                                ), 
                                React.createElement("h4", {className: "modal-title"}, this.props.title)
                            ), 
                            React.createElement("form", {className: "form-horizontal", onSubmit: this.handleSubmit}, 
                                React.createElement("div", {className: "modal-body"}, 
                                React.createElement("input", {type: "hidden", name: "musica", id: "musica", ref: "musica", defaultValue: this.props.musica}), 
                                React.createElement("p", {className: "control"}, 
                                    React.createElement("label", null, "Tipo Arquivo"), 
                                    React.createElement("select", {name: "tipo", id: "tipo", ref: "tipo", className: "input"}, 
                                        
                                            this.state.data.map(function (tipo) {
                                                return (
                                                    React.createElement("option", {key: tipo.id, value: tipo.id}, tipo.nome)
                                                )
                                            })
                                        
                                    )
                                ), 
                                React.createElement("p", {className: "control"}, 
                                    React.createElement("label", null, "Link"), 
                                    React.createElement("input", {className: "input", type: "text", placeholder: "Link", name: "link", id: "link", ref: "link", 
                                           required: true})
                                )
                                ), 
                                React.createElement("div", {className: "modal-footer"}, 
                                    React.createElement("button", {type: "button", className: "button is-danger is-outlined is-pulled-left", "data-dismiss": "modal"}, "Cancelar"), 
                                    React.createElement("button", {type: "submit", className: "button is-success"}, "Salvar")
                                )
                            )
                        )
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

    var styleCard = { width: '100%' };
    var styleImg = {
        minWidth: '64px', maxWidth: '64px', minHeight: '64px', maxHeight: '64px', margin: 'auto'
    };
    var styleCardLetra = {
        backgroundColor: 'transparent', border: 'none'
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

    class BtnRemover extends React.Component{

        render() {
            return(
              React.createElement("a", {className: "button is-danger is-inverted is-small", onClick: this.props.acao}, "Remover")
            );
        }

    }

    class BtnDownload extends React.Component{

        render() {
            return(
                React.createElement("a", {href: this.props.anexo, download: "download", className: "button is-white is-small"}, "Baixar")
            );
        }

    }

    class BtnVisualizar extends React.Component{

        render() {
            return(
                React.createElement("a", {href: this.props.anexo, target: "_Blank", className: "button is-light is-small"}, "Visualizar")
            );
        }
    }

    class BtnEditar extends React.Component{

        render() {
            return(
                React.createElement("a", {href: this.props.source, className: "button is-light is-small"}, "Editar")
            );
        }
    }

    class BtnAddLetra extends React.Component{

        render() {
            return(
                React.createElement("a", {href: this.props.source, className: "button is-primary is-inverted is-small"}, "Adicionar Letra")
            );
        }
    }

    class BtnAddLink extends React.Component{

        render() {
            return(
                React.createElement("a", {onClick: this.props.openModal, className: "button is-success is-inverted is-small"}, "Adicionar Link")
            );
        }
    }

    class BtnLink extends React.Component{

        render() {
            return(
                React.createElement("a", {href: this.props.href, target: "_Blank", className: "button is-white is-small"}, "Ir para o Link")
            );
        }
    }

    class CardLetra extends React.Component{

        render() {
            return (
                React.createElement("div", null, 
                    React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: styleCard}, 
                        React.createElement("div", {className: "card-content"}, 
                            React.createElement("div", {className: "media"}, 
                                React.createElement("div", {className: "media-content"}, 
                                    this.props.children
                                )
                            )
                        )
                    ), 
                    React.createElement("br", null)
                )
            )
        }
    };
    
    class BlockLetra extends React.Component{
        
        render() {

            return (
                React.createElement("pre", {id: "content", style: styleCardLetra, "data-key": this.props.musica.tom}, this.props.musica.letra)
            )
        }
        
    }

    class Font extends React.Component {

        render() {
            return (

                React.createElement("div", {id: "fontlinks"}, 
                    React.createElement("button", {id: "incfont", className: "button is-dark is-outlined is-small buttonfont"}, 
                        "A+"
                    ), 
                    React.createElement("button", {id: "decfont", className: "button is-dark is-outlined is-small buttonfont"}, 
                        "A-"
                    ), 
                    React.createElement(BtnEditar, {source: this.props.source})
                )
            )
        }

    }

    var RemoverArquivo = React.createClass({displayName: "RemoverArquivo",

        handleRemover : function (e) {

            e.preventDefault();

            var id = this.props.anexo.id;
            var _this = this;

            alertify.confirm("Deseja remover este arquivo?", function(){

                block_screen();

                $.ajax({
                    type: "POST",
                    url: "/user/musica/anexos/"+id+"/remover",
                    cache: false,
                    success: function (data) {
                        unblock_screen();
                        alertify.success(data.message);
                        _this.props.reloadArquivos();
                    },
                    error: function () {
                        unblock_screen();
                        alertify.error("Ocorreu um erro.");
                    }
                });
            }).setting("labels",{"ok":"Sim", "cancel": "Cancelar"});

        },

        render : function() {
            return (
              React.createElement(BtnRemover, {acao: this.handleRemover})
            );
        }

    });

    var ImagemArquivo = React.createClass({displayName: "ImagemArquivo",

        render : function () {

            var image = React.createElement("i", {className: "fa fa-music"}, " ");

            if (2 == this.props.anexo.tipo.id) {
                image = React.createElement("i", {className: "fa fa-picture-o"}, " ");
            } else if (3 == this.props.anexo.tipo.id) {
                image = React.createElement("i", {className: "fa file-pdf-o"}, " ");
            } else if (4 == this.props.anexo.tipo.id) {
                image = React.createElement("i", {className: "fa fa-video-camera"}, " ");
            }

            return (
                React.createElement("div", {className: "media-left media-middle"}, 
                    image
                )
            );
        }

    });

    var ListArquivos = React.createClass({displayName: "ListArquivos",
        
        render : function () {

            var _this = this;

            return (
                React.createElement("div", null, 
                    this.props.anexos.map(function (anexo) {

                        var arquivo = _this.props.dirAnexos + anexo.nome;

                        var visualzar = '';
                        var downLoad = '';
                        var link = '';

                        if (!anexo.isExterno) {
                            visualzar = React.createElement(BtnVisualizar, {anexo: arquivo});
                            downLoad = React.createElement(BtnDownload, {anexo: arquivo});
                        } else {
                            link = React.createElement(BtnLink, {href: _this.props.sourceVideos});
                        }
                        
                        return (
                            React.createElement("div", {key: anexo.id}, 
                                React.createElement("div", {className: "media"}, 
                                    React.createElement(ImagemArquivo, {anexo: anexo}), 
                                    React.createElement("div", {className: "media-body"}, 
                                        React.createElement("h4", {className: "media-heading"}, anexo.nome, 
                                            React.createElement("a", {className: "button is-light is-small is-pulled-right"}, anexo.cadastro)
                                        ), 
                                            visualzar, 
                                            downLoad, 
                                            link, 
                                            React.createElement(RemoverArquivo, {anexo: anexo, reloadArquivos: _this.props.reloadArquivos})
                                    )
                                )
                            )
                        )
                    })
                )
            );   
        }

    });

    var ViewArquivos = React.createClass({displayName: "ViewArquivos",

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            $.get(this.props.sourceArquivos, function (result) {
                this.setState({data: result});
            }.bind(this));
        },
        componentDidMount: function () {
            this.load();
        },

        openModal: function () {
            $("#modal-musicas").modal("show");
        },
        closeModal: function () {
            $("#modal-musicas").modal("hide");
        },
        openModalAddLink :  function () {
            $("#modal-add-link").modal("show");
        },
        closeModalAddLink: function () {
            $("#modal-add-link").modal("hide");
        },

        render: function () {

            return (
                React.createElement("div", null, 
                React.createElement("div", {className: "card wow fadeInUp animated slide", "data-wow-delay": ".3s", style: styleCard}, 
                    React.createElement("div", {className: "card-content"}, 
                        React.createElement("div", {className: "media"}, 
                            React.createElement("div", {className: "media-content"}, 
                                React.createElement(BtnEditar, {source: this.props.sourceEditar}), 
                                React.createElement(BtnAddLetra, {source: this.props.sourceAddLetra}), 
                                React.createElement(BtnAddLink, {openModal: this.openModalAddLink}), 
                                React.createElement("button", {onClick: this.openModal, className: "button is-danger is-inverted is-small"}, "Adicionar Arquivo"), 
                                React.createElement("br", null), 
                                React.createElement(ListArquivos, {reloadArquivos: this.load, anexos: this.state.data, sourceArquivos: this.props.sourceArquivos, sourceVideos: this.props.sourceVideos, dirAnexos: this.props.dirAnexos})
                            )
                        )
                    )
                ), 
                    React.createElement(UploadArquivo, {reloadArquivos: this.load, openModal: this.openModal, closeModal: this.closeModal, musica: this.props.musica}), 
                    React.createElement(AddLink, {reloadArquivos: this.load, openModal: this.openModalAddLink, closeModal: this.closeModalAddLink, musica: this.props.musica}), 
                    React.createElement("br", null)
                )
            );
        }
    });

    var ViewLetra = React.createClass({displayName: "ViewLetra",

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            $.get(this.props.sourceMusica, function (result) {
                this.setState({data: result});
            }.bind(this));
        },
        componentDidMount: function () {
            this.load();
        },

        render : function() {
            return (
                React.createElement(CardLetra, null, 
                    React.createElement(Font, {source: this.props.sourceAddLetra}), 
                    React.createElement("br", null), 
                    React.createElement(BlockLetra, {musica: this.state.data})
                )
            )
        }
    });

    var source = $("#comentarios").attr("data-source");
    var sourceArquivos = $("#comentarios").attr("data-source-arquivos");
    var sourceVideos = $("#comentarios").attr("data-source-videos");
    var sourceEditar = $("#comentarios").attr("data-source-editar");
    var sourceAddLetra = $("#comentarios").attr("data-source-add-letra");
    var sourceMusica= $("#comentarios").attr("data-source-musica");
    
    var musicaId = $("#comentarios").attr("data-musica-id");
    var user = $("#comentarios").attr("data-user");
    var dirAvatar = $("#comentarios").attr("data-dir-avatar");
    var dirAnexos = $("#comentarios").attr("data-dir-anexos");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(ViewLetra, {sourceMusica: sourceMusica, sourceAddLetra: sourceAddLetra}), 
            React.createElement(ViewArquivos, {sourceArquivos: sourceArquivos, sourceEditar: sourceEditar, sourceAddLetra: sourceAddLetra, sourceVideos: sourceVideos, musica: musicaId, dirAnexos: dirAnexos}), 
            React.createElement(ViewCometarios, {source: source, user: user, dirAvatar: dirAvatar, musicaId: musicaId})
        ),
        document.getElementById('comentarios')
    );

    $('#incfont').click(function () {
        curSize = parseInt($('#content').css('font-size')) + 2;
        curSize2 = parseInt($('.c').css('font-size')) + 2;
        if (curSize <= 32)
            $('#content').css('font-size', curSize);
        if (curSize2 <= 32)
            $('.c').css('font-size', curSize2);
    });
    $('#decfont').click(function () {
        curSize = parseInt($('#content').css('font-size')) - 2;
        curSize2 = parseInt($('.c').css('font-size')) - 2;
        if (curSize >= 5)
            $('#content').css('font-size', curSize);
        if (curSize2 >= 5)
            $('.c').css('font-size', curSize2);
    });
    $(function () {
        $("pre").transpose({ key : 'C' });
        $('.c').css('font-size', 8);
        $('#content').css('font-size', 8)
    });
});