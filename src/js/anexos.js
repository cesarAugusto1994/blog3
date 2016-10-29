/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var Modal = React.createClass({
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
                <div id="modal-musicas" className="modal fade" tabIndex="-1">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                                <h4 className="modal-title">{this.props.title}</h4>
                            </div>
                            <form className="form-horizontal" ref="uploadForm" onSubmit={this.props.handleSubmit}>
                                <div className="modal-body">
                                    {this.props.children}
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="button is-danger is-outlined is-pulled-left" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" className="button is-success">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            )
        }
    });

    var UploadArquivo = React.createClass({

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
                <Modal title="Upload de Arquivos" handleSubmit={this.handleSubmit}>
                    <input type="hidden" name="musica" ref="id" defaultValue={this.props.musica} />
                    <input className="input" type="file" ref="arquivo" name="files[]" id="filer_input" multiple="multiple"
                           accept="image/gif, image/jpeg, image/png, image/jpg, audio/mpeg, audio/mp3, application/octet-stream, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                </Modal>
            );

            return (
                <div>
                    {modal}
                </div>
            );
        }
    });

    var styleCard = { width: '100%' };
    var styleImg = {
        minWidth: '64px', maxWidth: '64px', minHeight: '64px', maxHeight: '64px', margin: 'auto'
    };

    var RemoverComentario = React.createClass({

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
                <a className="button is-danger is-inverted is-small" onClick={this.handleRemoverComentario} data-comentario={this.props.comentario}>Inativar</a>
            )
        }
    });

    var CardComentarios = React.createClass({

        render: function () {
            return (
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={styleCard}>
                    <div className="card-content">
                        <p className="title is-3">Coment&aacute;rios</p>
                        <div className="comments">
                            {this.props.children}
                        </div>
                    </div>
                </div>
            );
        }

    });

    var ListComentarios = React.createClass({

        render: function () {

            var _this = this;

            return (
                <div>
                    {this.props.data.map(function (comentario) {

                        var img = _this.props.dirAvatar + comentario.usuario.avatar;

                        return (
                            <div key={comentario.id}>
                                <div className="media">
                                    <ImageComentario avatar={img}/>
                                    <div className="media-body">
                                        <h4 className="media-heading">{comentario.usuario.nome}
                                            <RemoverComentario comentario={comentario} reloadComentarios={_this.props.reloadComentarios} />
                                            <a className="button is-light is-small is-pulled-right">{comentario.cadastro}</a>
                                        </h4>
                                        <p>
                                            {comentario.comentario}
                                        </p>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        )
                    })}
                </div>
            );
        }
    });

    var ImageComentario = React.createClass({

        render : function () {
            return (
                <a className="pull-left">
                    <img style={styleImg}
                         alt=""
                         src={this.props.avatar}
                         className="media-object" />
                </a>
            );
        }
    });

    var FormComentario = React.createClass({

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
                <div className="post-comment">
                    <form className="form-horizontal">
                        <input type="hidden" name="musica_id" id="musica_id" ref="id" defaultValue={this.props.musicaId} />
                            <div className="form-group">
                                <div className="col-lg-12">
                                    <textarea className=" form-control" name="comentario" id="comentario" ref="comentario" rows="3" placeholder="Comentar"></textarea>
                                </div>
                            </div>
                            <p>
                                <button id="comentar" ref="submit" className="button is-danger" onClick={this.handleSubmit}>Comentar</button>
                            </p>
                    </form>
                </div>
            );
        }
    });

    var ViewCometarios = React.createClass({

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
                <div>
                    <CardComentarios>
                        <ListComentarios data={this.state.data} dirAvatar={this.props.dirAvatar} reloadComentarios={this.load} />
                        <FormComentario musicaId={this.props.musicaId} reloadComentarios={this.load} />
                    </CardComentarios>
                </div>
            )
        }
    });

    class BtnRemover extends React.Component{

        render() {
            return(
              <a className="button is-danger is-inverted is-small" onClick={this.props.acao}>Remover</a>
            );
        }

    }

    class BtnDownload extends React.Component{

        render() {
            return(
                <a href={this.props.anexo} download="download" className="button is-white is-small">Baixar</a>
            );
        }

    }

    class BtnVisualizar extends React.Component{

        render() {
            return(
                <a href={this.props.anexo} target="_Blank" className="button is-light is-small">Visualizar</a>
            );
        }
    }

    class BtnEditar extends React.Component{

        render() {
            return(
                <a href={this.props.source} className="button is-light is-small">Editar</a>
            );
        }
    }

    class BtnAddLetra extends React.Component{

        render() {
            return(
                <a href={this.props.source} className="button is-primary is-inverted is-small">Adicionar Letra</a>
            );
        }
    }

    class BtnAddLink extends React.Component{

        render() {
            return(
                <a data-toggle="modal" data-target="#addLink" className="button is-success is-inverted is-small addAnexo">Adicionar Link</a>
            );
        }
    }

    class BtnLink extends React.Component{

        render() {
            return(
                <a href={this.props.href} target="_Blank" className="button is-white is-small">Ir para o Link</a>
            );
        }
    }

    var RemoverArquivo = React.createClass({

        handleRemover : function (e) {

            e.preventDefault();

            console.log(this.props);

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
              <BtnRemover acao={this.handleRemover} />
            );
        }

    });

    var ImagemArquivo = React.createClass({

        render : function () {

            var image = <i className="fa fa-music">&nbsp;</i>;

            if (2 == this.props.anexo.tipo.id) {
                image = <i className="fa fa-picture-o">&nbsp;</i>;
            } else if (3 == this.props.anexo.tipo.id) {
                image = <i className="fa file-pdf-o">&nbsp;</i>;
            } else if (4 == this.props.anexo.tipo.id) {
                image = <i className="fa fa-video-camera">&nbsp;</i>;
            }

            return (
                <div className="media-left media-middle">
                    {image}
                </div>
            );
        }

    });

    var ListArquivos = React.createClass({
        
        render : function () {

            var _this = this;

            return (
                <div>
                    {this.props.anexos.map(function (anexo) {

                        var arquivo = _this.props.dirAnexos + anexo.nome;

                        var visualzar = '';
                        var downLoad = '';
                        var link = '';

                        if (!anexo.isExterno) {
                            visualzar = <BtnVisualizar anexo={arquivo} />;
                            downLoad = <BtnDownload anexo={arquivo} />;
                        } else {
                            link = <BtnLink href={_this.props.sourceVideos} />;
                        }
                        
                        return (
                            <div key={anexo.id}>
                                <div className="media">
                                    <ImagemArquivo anexo={anexo} />
                                    <div className="media-body">
                                        <h4 className="media-heading">{anexo.nome}
                                            <a className="button is-light is-small is-pulled-right">{anexo.cadastro}</a>
                                        </h4>
                                            {visualzar}
                                            {downLoad}
                                            {link}
                                            <RemoverArquivo anexo={anexo} reloadArquivos={_this.props.reloadArquivos}/>
                                    </div>
                                </div>
                            </div>
                        )
                    })}
                </div>
            );   
        }

    });

    var ViewArquivos = React.createClass({

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

        render: function () {

            return (
                <div>
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={styleCard}>
                    <div className="card-content">
                        <div className="media">
                            <div className="media-content">
                                <BtnEditar source={this.props.sourceEditar} />
                                <BtnAddLetra source={this.props.sourceAddLetra}/>
                                <BtnAddLink />
                                <button data-toggle="modal" data-target="#modal-musicas" onClick={this.openModal} className="button is-danger is-inverted is-small">Adicionar Arquivo</button>
                                <br />
                                <ListArquivos reloadArquivos={this.load} anexos={this.state.data} sourceArquivos={this.props.sourceArquivos} sourceVideos={this.props.sourceVideos} dirAnexos={this.props.dirAnexos}/>
                            </div>
                        </div>
                    </div>
                </div>
                    <UploadArquivo reloadArquivos={this.load} openModal={this.openModal} closeModal={this.closeModal} musica={this.props.musica} />
                    <br />
                </div>
            );
        }
    });

    var source = $("#comentarios").attr("data-source");
    var sourceArquivos = $("#comentarios").attr("data-source-arquivos");
    var sourceVideos = $("#comentarios").attr("data-source-videos");
    var sourceEditar = $("#comentarios").attr("data-source-editar");
    var sourceAddLetra = $("#comentarios").attr("data-source-add-letra");
    
    var musicaId = $("#comentarios").attr("data-musica-id");
    var user = $("#comentarios").attr("data-user");
    var dirAvatar = $("#comentarios").attr("data-dir-avatar");
    var dirAnexos = $("#comentarios").attr("data-dir-anexos");

    ReactDOM.render(
        <div>
            <ViewArquivos sourceArquivos={sourceArquivos} sourceEditar={sourceEditar} sourceAddLetra={sourceAddLetra} sourceVideos={sourceVideos} musica={musicaId} dirAnexos={dirAnexos}/>
            <ViewCometarios source={source} user={user} dirAvatar={dirAvatar} musicaId={musicaId}/>
        </div>,
        document.getElementById('comentarios')
    );
});