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
                <div id="scheduleentry-modal" className="modal fade" tabIndex="-1">
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
                <Modal title="Upload de Arquivos" handleSubmit={this.handleSubmit}>
                    <input type="hidden" name="musica" ref="id" defaultValue={this.props.musica} />
                    <input className="input" type="file" ref="arquivo" name="files[]" id="filer_input" multiple="multiple" />
                </Modal>
            );

            return (
                <div className="scheduleentry-modal">
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

    var ListArquivos = React.createClass({

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
                <div>
                    {this.state.data.map(function (anexo) {
                        
                        return (
                            <div key={anexo.id}>
                                <div className="media">
                                    <div className="media-body">
                                        <h4 className="media-heading">{anexo.nome}
                                            <a className="button is-light is-small is-pulled-right">{anexo.cadastro}</a>
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

    var ViewArquivos = React.createClass({

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
                <div>
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={styleCard}>
                    <div className="card-content">
                        <div className="media">
                            <div className="media-content">
                                <button data-toggle="modal" data-target="#scheduleentry-modal" onClick={this.openModal} className="button is-danger is-inverted is-small">Adicionar Arquivo</button>
                                <ListArquivos sourceArquivos={this.props.sourceArquivos}/>
                            </div>
                        </div>
                    </div>
                </div>
                    <UploadArquivo closeModal={this.closeModal} musica={this.props.musica} />
                </div>
            );
        }
    });

    var source = $("#comentarios").attr("data-source");
    var sourceArquivos = $("#comentarios").attr("data-source-arquivos");
    var musicaId = $("#comentarios").attr("data-musica-id");
    var user = $("#comentarios").attr("data-user");
    var dirAvatar = $("#comentarios").attr("data-dir-avatar");

    ReactDOM.render(
        <div>
            <ViewArquivos sourceArquivos={sourceArquivos} musica={musicaId}/>
            <ViewCometarios source={source} user={user} dirAvatar={dirAvatar} musicaId={musicaId}/>
        </div>,
        document.getElementById('comentarios')
    );
});