/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    var UploadArquivo = React.createClass({

        handleSubmit: function (e) {

            e.preventDefault();

            var _this = this;

            var id = this.refs.id.value.trim();
            var arquivo = this.refs.arquivo.value.trim();

            if (!arquivo) {
                alertify.error("Erro no arquivo.");
                return false;
            }

            var fd = new FormData();
            var files = this.refs.arquivo.files;

            $.each(files, function (index, value) {
                fd.append('files[]', files[index]);
            });

            $("#btn-upload").addClass("is-loading");
            block_screen();

            $.ajax({
                type: "POST",
                url: "/user/musica/" + id + "/anexos/upload",
                enctype: "multipart/form-data",
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadArquivos();
                    _this.props.closeModal();
                    $("#btn-upload").removeClass("is-loading");
                    unblock_screen();
                },
                error: function (data) {
                    $("#btn-upload").removeClass("is-loading");
                    alertify.error(data.message);
                    unblock_screen();
                }
            });

        },

        render: function () {

            let modal = (
                <div id="modal-musicas" className="modal fade" tabIndex="-1">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                                <h4 className="modal-title">Adicionar Arquivos</h4>
                            </div>
                            <form className="form-horizontal" ref="uploadForm" onSubmit={this.handleSubmit}>
                                <div className="modal-body">
                                    <input type="hidden" name="musica" ref="id" defaultValue={this.props.musica}/>
                                    <input className="input" type="file" ref="arquivo" name="files[]" id="filer_input"
                                           multiple/>
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="button is-danger is-pulled-left"
                                            data-dismiss="modal">Fechar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            );

            return (
                <div>
                    {modal}
                </div>
            );
        }
    });

    var AddLink = React.createClass({

        handleSubmit: function (e) {

            e.preventDefault();

            const _this = this;

            var id = this.refs.musica.value.trim();
            var tipo = this.refs.tipo.value.trim();
            var link = this.refs.link.value.trim();
            var nome = this.refs.nome.value.trim();

            if (!link) {
                alertify.error("Erro no arquivo.");
                return false;
            }

            $("#btn-upload").addClass("is-loading");
            block_screen();

            $.ajax({
                type: "POST",
                url: "/user/musica/" + id + "/anexos/save",
                data: {
                    id: id,
                    nome: nome,
                    tipo: tipo,
                    link: link
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

        render: function () {

            var modal = null;
            modal = (
                <div id="modal-add-link" className="modal fade" tabIndex="-1">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                                <h4 className="modal-title">{this.props.title}</h4>
                            </div>
                            <form className="form-horizontal" onSubmit={this.handleSubmit}>
                                <div className="modal-body">
                                    <input type="hidden" name="musica" id="musica" ref="musica"
                                           defaultValue={this.props.musica}/>
                                    <p className="control">
                                        <label>Titulo</label>
                                        <input className="input" type="text" placeholder="Titulo" name="nome" id="nome"
                                               ref="nome"/>
                                    </p>
                                    <p className="control">
                                        <label>Tipo Arquivo</label>
                                        <select name="tipo" id="tipo" ref="tipo" className="input">
                                            {
                                                this.state.data.map(function (tipo) {
                                                    return (
                                                        <option key={tipo.id} value={tipo.id}>{tipo.nome}</option>
                                                    )
                                                })
                                            }
                                        </select>
                                    </p>
                                    <p className="control">
                                        <label>Link</label>
                                        <input className="input" type="text" placeholder="Link" name="link" id="link"
                                               ref="link"
                                               required/>
                                    </p>
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="button is-danger is-outlined is-pulled-left"
                                            data-dismiss="modal">Cancelar
                                    </button>
                                    <button type="submit" className="button is-success">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            );

            return (
                <div>
                    {modal}
                </div>
            );
        }
    });

    var styleCard = {width: '100%', minWidth: '150px'};
    var styleImg = {
        minWidth: '64px', maxWidth: '64px', minHeight: '64px', maxHeight: '64px', margin: 'auto'
    };
    var styleCardLetra = {
        backgroundColor: 'transparent', border: 'none',
    };

    var RemoverComentario = React.createClass({

        handleRemoverComentario: function (e) {

            e.preventDefault();

            const _this = this;

            alertify.confirm("Deseja remover este Coment&aacute;rio?", function () {

                block_screen();

                $.ajax({
                    type: 'POST',
                    url: '/user/musica/anexos/comentario/' + _this.props.comentario.id + '/remover',
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


        render: function () {

            return (
                <button className="button is-light is-small" onClick={this.handleRemoverComentario}
                   data-comentario={this.props.comentario}>Remover</button>
            )
        }
    });

    var CardComentarios = React.createClass({

        render: function () {
            return (
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={styleCard}>
                    <div className="card-content">
                        <p className="title is-5">Coment&aacute;rios</p>
                        <div className="comments">
                            {this.props.children}
                        </div>
                    </div>
                </div>
            );
        }

    });

    const ListComentarios = React.createClass({

        componentDidMount: function () {
            return setInterval(this.props.reloadComentarios, 10000);
        },

        render: function () {

            const _this = this;

            return (
                <div>
                    {_this.props.data.map(function (comentario) {

                        let img = _this.props.dirAvatar + comentario.usuario.avatar;

                        let removerComentario = '';

                        if (_this.props.user == ROLE_ADMIN || comentario.usuario.id == _this.props.userId) {
                            removerComentario = <RemoverComentario comentario={comentario}
                                                                   reloadComentarios={_this.props.reloadComentarios}/>
                        }

                        return (
                            <div key={comentario.id} className="media">
                                <ImageComentario avatar={img}/>
                                <div className="media-body">
                                    <h4 className="media-heading">{comentario.usuario.nome}
                                        &nbsp;
                                        <a className="button is-white is-small">{comentario.cadastro}</a>
                                    </h4>
                                    <p className="text-muted">
                                        {comentario.comentario}
                                    </p>
                                </div>
                                {removerComentario}
                            </div>
                        )
                    })}
                </div>
            );
        }
    });

    var ImageComentario = React.createClass({

        render: function () {
            return (
                <a className="pull-left">
                    <img style={styleImg}
                         alt="user"
                         src={this.props.avatar}
                         className="media-object  img img-circle"/>
                </a>
            );
        }
    });

    var FormComentario = React.createClass({

        handleSubmit: function (e) {

            e.preventDefault();

            var id = this.refs.id.value.trim();
            var comentario = this.refs.comentario.value.trim();

            var _this = this;

            if ('' == comentario) {
                $("#comentario").addClass("is-danger");
                alertify.error('Deve informar um comentario');
                _this.refs.comentario.focus();
                return false;
            }

            $("#comentario").removeClass("is-danger");
            $("#comentar").addClass("is-loading");

            $.ajax({
                type: "POST",
                url: "/user/musica/" + id + "/anexos/comentar",
                data: {
                    "id": id,
                    "comentario": comentario
                },
                cache: false,
                success: function (data) {
                    $("#comentar").removeClass("is-loading");
                    unblock_screen();
                    $(".emojionearea-editor").text("");
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

        render: function () {

            return (
                <div className="post-comment">
                    <form className="form-horizontal">
                        <input type="hidden" name="musica_id" id="musica_id" ref="id"
                               defaultValue={this.props.musicaId}/>
                        <div className="form-group">
                            <div className="col-lg-12">
                                <textarea className="textarea" name="comentario" id="comentario" ref="comentario" placeholder="Deixe o seu comentário"></textarea>
                            </div>
                        </div>
                        <p>
                            <button id="comentar" ref="submit" className="button is-fullwidth is-danger" onClick={this.handleSubmit}>
                                Enviar
                            </button>
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

        render: function () {
            return (
                <div>
                    <CardComentarios>
                        <ListComentarios user={this.props.user} userId={this.props.userId} data={this.state.data}
                                         dirAvatar={this.props.dirAvatar}
                                         reloadComentarios={this.load}/><br/>
                        <FormComentario musicaId={this.props.musicaId} reloadComentarios={this.load}/>
                    </CardComentarios>
                </div>
            )
        }
    });

    class BtnRemover extends React.Component {

        render() {
            return (
                <a className="button is-danger is-inverted is-small" onClick={this.props.acao}>Remover</a>
            );
        }

    }

    class BtnDownload extends React.Component {

        render() {
            return (
                <a href={this.props.anexo} download="download" className="button is-white is-small">Baixar</a>
            );
        }

    }

    class BtnVisualizar extends React.Component {

        render() {
            return (
                <a href={this.props.anexo} target="_Blank" className="button is-light is-small">Visualizar</a>
            );
        }
    }

    class BtnEditar extends React.Component {

        render() {
            return (
                <a href={this.props.source} className="button is-light is-small is-pulled-right">Editar Letra</a>
            );
        }
    }

    class BtnView extends React.Component {

        render() {
            return (
                <a href={this.props.sourceView} className="button is-danger is-small">LETRA</a>
            );
        }
    }

    class BtnEditarMusica extends React.Component {

        render() {
            return (
                <a href={this.props.source} className="button is-light is-small">Editar Música</a>
            );
        }
    }

    class BtnAdicionarArquivo extends React.Component {

        render() {
            return (
                <button onClick={this.props.openModal} className="button is-light is-small">
                Adicionar Arquivo</button>
            );
        }
    }

    class BtnAddLetra extends React.Component {

        render() {
            return (
                <a href={this.props.source} className="button is-light is-small">Adicionar Letra</a>
            );
        }
    }

    class BtnAddLink extends React.Component {

        render() {
            return (
                <a onClick={this.props.openModal} className="button is-light is-small">Adicionar Link</a>
            );
        }
    }

    class BtnLink extends React.Component {

        render() {
            return (
                <a href={this.props.href} target="_Blank" className="button is-white is-small">Ir para o Link</a>
            );
        }
    }

    class BtnFavoritos extends React.Component {

        render() {

            let btn = '';

            if (this.props.isFavorito === true) {
                btn = (<a className="button is-small is-danger is-inverted add-remove" onClick={this.props.handle}>Remover dos Favoritos</a>);
            } else {
                btn = (<a className="button is-small is-light add-remove"  onClick={this.props.handle}>Adicionar aos Favoritos</a>);
            }

            return (
                <span>{btn}</span>
            );
        }
    }

    class CardLetra extends React.Component {

        render() {
            return (
                <div>
                    <div className="card wow fadeInUp animated slide" style={styleCard}>
                        <div className="card-content">
                            <div className="media">
                                <div className="media-content">
                                    {this.props.children}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )
        }
    }
    ;

    class BlockLetra extends React.Component {

        render() {
            return (
                <pre id="content" style={styleCardLetra}
                     data-key={this.props.sourceMusicaTom}>{this.props.sourceMusicaLetra}</pre>
            )
        }

    }

    class Font extends React.Component {

        render() {
            return (
            <div className="control is-grouped" id="fontlinks">
                <p className="control has-addon">
                    <button id="incfont" className="button is-light is-small buttonfont">
                        A+
                    </button>
                </p>
                <p className="control">
                    <button id="decfont" className="button is-light is-small buttonfont">
                        A-
                    </button>
                </p>
                <p className="control">
                    <BtnView sourceView={this.props.sourceView}/>
                </p>
                <p className="control">
                    <BtnEditar source={this.props.source}/>
                </p>
            </div>
            )
        }
    }

    var RemoverArquivo = React.createClass({

        handleRemover: function (e) {

            e.preventDefault();

            var id = this.props.anexo.id;
            var _this = this;

            alertify.confirm("Deseja remover este arquivo?", function () {

                block_screen();

                $.ajax({
                    type: "POST",
                    url: "/user/musica/anexos/" + id + "/remover",
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
            }).setting("labels", {"ok": "Sim", "cancel": "Cancelar"});

        },

        render: function () {
            return (
                <BtnRemover acao={this.handleRemover}/>
            );
        }

    });

    var ImagemArquivo = React.createClass({

        render: function () {

            if (!this.props.anexo.tipo) {
                alertify.error("Nenhum tipo foi cadastrado para o arquivo.");
                return false;
            }

            let icone = 'fa fa-music';

            if (this.props.anexo.tipo.icone.length > 0) {
                icone = this.props.anexo.tipo.icone;
            }

            let image = <i className={icone}>&nbsp;</i>;

            return (
                <div className="media-left media-middle">
                    {image}
                </div>
            );
        }

    });

    const ListArquivos = React.createClass({

        componentDidMount: function () {
            return setInterval(this.props.reloadArquivos, 3000);
        },

        render: function () {

            const _this = this;

            return (
                <ul className="list-group">
                    {this.props.anexos.map(function (anexo) {

                        let arquivo = _this.props.dirAnexos + anexo.nome;

                        let visualzar = '';
                        let downLoad = '';
                        let link = '';
                        let btn = '';
                        let videos = '';

                        if (!anexo.isExterno) {
                            visualzar = <BtnVisualizar anexo={arquivo}/>;
                            downLoad = <BtnDownload anexo={arquivo}/>;
                        } else {
                            if ('Video' == anexo.tipo.nome) {
                                videos = '/user/praise/' + anexo.musica.id + '-' + anexo.musica.nome.toLowerCase().replace(/ /g, '_') + '/videos';
                            } else {
                                videos = anexo.link;
                            }
                            link = <BtnLink href={videos}/>;
                        }

                        if (ROLE_ADMIN == _this.props.user || _this.props.userId == anexo.usuario) {
                            btn = (<RemoverArquivo anexo={anexo} reloadArquivos={_this.props.reloadArquivos}/>);
                        }

                        return (
                            <li className="list-group-item" key={anexo.id}>
                                <p>{anexo.nome}</p>
                                <p>
                                <small>Enviado por { anexo.usuario } em { anexo.cadastro }</small>
                                {visualzar}
                                {link}
                                {btn}
                                </p>
                            </li>
                        )
                    })}
                </ul>
            );
        }
    });

    const ViewOpcoes = React.createClass({

        getInitialState: function () {
            return {data: [], favorito : false};
        },
        load: function () {
            $.get(this.props.sourceArquivos, function (result) {
                this.setState({data: result});
            }.bind(this));
        },

        loadFavoritos : function () {
            $.get('/api/favorites/praise/' + this.props.musica, function (result) {
                this.setState({favorito: result.length > 0});
            }.bind(this));
        },

        componentDidMount: function () {
            this.load();
            this.loadFavoritos();
        },

        openModal: function () {
            $("#modal-musicas").modal("show");
        },
        closeModal: function () {
            $("#modal-musicas").modal("hide");
        },
        openModalAddLink: function () {
            $("#modal-add-link").modal("show");
        },
        closeModalAddLink: function () {
            $("#modal-add-link").modal("hide");
        },

        handleFavoritos : function () {

            const _this = this;
            let id = this.props.musica;
            $("#add-remove").addClass("is-loading");

            $.ajax({
                type: "POST",
                url: "/api/favoritos/add-remove",
                data: {
                    "id": id,
                },
                cache: false,
                success: function (data) {
                    _this.loadFavoritos();
                    $("#add-remove").removeClass("is-loading");
                    alertify.success(data.mensagem);
                },
                error: function () {
                    $("#add-remove").removeClass("is-loading");
                    alertify.error("Ocorreu um erro.");
                }
            });
        },

        render: function () {

            let menu = '';
            let card = '';
            let letra = '';
            let cardArquivos = (<CardLetra label="Letra">Sem anexos disponíveis.</CardLetra>);

            if (!this.props.dataMusica.letra) {
                letra = (
                    <BtnAddLetra source={this.props.sourceAddLetra}/>
                )
            } else {
                letra = (
                    <BtnView sourceView={this.props.sourceView}/>
                )
            }

            if (this.props.user == ROLE_ADMIN) {
                menu = (
                    <div className="block">
                        <BtnFavoritos handle={this.handleFavoritos} isFavorito={this.state.favorito}
                                      dataMusica={this.props.dataMusica}/>
                        <BtnEditarMusica source={this.props.sourceEditar}/>
                        <BtnAddLink openModal={this.openModalAddLink}/>
                        <BtnAdicionarArquivo openModal={this.openModal}/>
                        {letra}
                    </div>
                )
            } else {
                menu = (
                    <div className="control is-grouped">
                        <p className="control">
                            <BtnFavoritos handle={this.handleFavoritos} isFavorito={this.state.favorito} dataMusica={this.props.dataMusica}/>
                        </p>
                        <p className="control">
                            <BtnAdicionarArquivo openModal={this.openModal}/>
                        </p>
                        <p className="control">
                            {letra}
                        </p>
                    </div>
                )
            }

            card = (
                <div>
                    <UploadArquivo reloadArquivos={this.load} openModal={this.openModal}
                                   closeModal={this.closeModal}
                                   musica={this.props.musica}/>
                    <AddLink reloadArquivos={this.load} openModal={this.openModalAddLink}
                             closeModal={this.closeModalAddLink} musica={this.props.musica}/>
                </div>
            );

            if (this.state.data.length > 0) {
                cardArquivos = (
                    <CardLetra label="Arquivos">
                        <ListArquivos reloadArquivos={this.load}
                                      anexos={this.state.data}
                                      sourceArquivos={this.props.sourceArquivos}
                                      sourceVideos={this.props.sourceVideos}
                                      user={this.props.user}
                                      userId={this.props.userId}
                                      dirAnexos={this.props.dirAnexos}/>
                    </CardLetra>
                )
            }

            let cardLetra = (<CardLetra label="Letra">Sem letra disponível.</CardLetra>);

            if (this.props.sourceMusicaLetra) {
                cardLetra = (
                    <CardLetra label="Letra">
                        <Font
                            source={this.props.sourceAddLetra}
                            sourceView={this.props.sourceView}/>
                        <BlockLetra
                            musica={this.props.dataMusica}
                            sourceMusicaLetra={this.props.sourceMusicaLetra}
                            sourceMusicaTom={this.props.sourceMusicaTom}/>
                    </CardLetra>
                )
            }

            return (

                <div>
                    <CardLetra label="Menu">
                        {menu}
                    </CardLetra>
                    {card}
                    <br/>
                    <div>
                        <ul className="tabs is-toggle is-fullwidth" role="tablist">
                            <li role="presentation" className="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Arquivos</a></li>
                            <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Letra</a></li>
                            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Informações</a></li>
                        </ul>

                        <div className="tab-content">
                            <div role="tabpanel" className="tab-pane active" id="profile">{cardArquivos}</div>
                            <div role="tabpanel" className="tab-pane" id="home">{cardLetra}</div>
                            <div role="tabpanel" className="tab-pane" id="messages"><CardLetra label="Letra">Em Breve</CardLetra></div>
                        </div>
                    </div>
                    <br/>
                </div>
            )
        }
    });

    const ViewLetra = React.createClass({

        render: function () {

            let card = '';

            if (this.props.sourceMusicaLetra) {
                card = (
                    <CardLetra label="Letra">
                        <Font
                            source={this.props.sourceAddLetra}
                            sourceView={this.props.sourceView}/>
                        <BlockLetra
                            musica={this.props.dataMusica}
                            sourceMusicaLetra={this.props.sourceMusicaLetra}
                            sourceMusicaTom={this.props.sourceMusicaTom}/>
                    </CardLetra>
                )
            }

            return (
                <div>{card}</div>
            )
        }
    });

    const Render = React.createClass({

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

        render: function () {
            return (
                <Base>
                    <ViewOpcoes
                        dataMusica={this.state.data}
                        sourceArquivos={this.props.sourceArquivos}
                        sourceEditar={this.props.sourceEditar}
                        sourceMusicaLetra={this.props.sourceMusicaLetra}
                        sourceMusicaTom={this.props.sourceMusicaTom}
                        sourceAddLetra={this.props.sourceAddLetra}
                        sourceVideos={this.props.sourceVideos}
                        musica={this.props.musicaId}
                        dirAnexos={this.props.dirAnexos}
                        user={this.props.user}
                        userId={this.props.userId}
                        sourceView={this.props.sourceView}/>
                    <ViewCometarios
                        source={this.props.source}
                        user={this.props.user}
                        userId={this.props.userId}
                        dirAvatar={this.props.dirAvatar}
                        musicaId={this.props.musicaId}/>
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

    const source = $("#comentarios").attr("data-source");
    const sourceView = $("#comentarios").data("source-view");
    const sourceArquivos = $("#comentarios").attr("data-source-arquivos");
    const sourceVideos = $("#comentarios").attr("data-source-videos");
    const sourceEditar = $("#comentarios").attr("data-source-editar");
    const sourceAddLetra = $("#comentarios").attr("data-source-add-letra");
    const sourceMusica = $("#comentarios").attr("data-source-musica");
    const sourceMusicaLetra = $("#comentarios").attr("data-source-musica-letra");
    const sourceMusicaTom = $("#comentarios").attr("data-source-musica-tom");

    const musicaId = $("#comentarios").attr("data-musica-id");
    const user = $("#comentarios").attr("data-user");
    const userId = $("#comentarios").data("user-id");
    const dirAvatar = $("#comentarios").attr("data-dir-avatar");
    const dirAnexos = $("#comentarios").attr("data-dir-anexos");

    if (document.getElementById('comentarios')) {

        ReactDOM.render(
                <Render sourceMusica={sourceMusica}
                        sourceAddLetra={sourceAddLetra}
                        sourceView={sourceView}
                        sourceArquivos={sourceArquivos}
                        sourceEditar={sourceEditar}
                        sourceVideos={sourceVideos}
                        musica={musicaId}
                        dirAnexos={dirAnexos}
                        source={source}
                        user={user}
                        userId={userId}
                        dirAvatar={dirAvatar}
                        musicaId={musicaId}
                        sourceMusicaLetra={sourceMusicaLetra}
                        sourceMusicaTom={sourceMusicaTom}
                />,
            document.getElementById('comentarios')
        );

        var fd = new FormData();
        var files = $('#filer_input').val();

        $.each(files, function (index, value) {
            fd.append('files[]', files[index]);
        });

        $('#filer_input').filer(
            {
                limit: 20,
                maxSize: 15,
                extensions: null,
                changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Arraste e solte arquivos aqui</h3> <span style="display:inline-block; margin: 15px 0">ou</span></div><a class="jFiler-input-choose-btn blue">Selecionar Arquivos</a></div></div>',
                showThumbs: true,
                theme: "dragdropbox",
                templates: {
                    box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                    item: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
												<span class="jFiler-item-others">{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
									{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li>{{fi-progressBar}}</li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
                    itemAppend: '<li class="jFiler-item">\
							<div class="jFiler-item-container">\
								<div class="jFiler-item-inner">\
									<div class="jFiler-item-thumb">\
										<div class="jFiler-item-status"></div>\
										<div class="jFiler-item-thumb-overlay">\
											<div class="jFiler-item-info">\
												<div style="display:table-cell;vertical-align: middle;">\
													<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
													<span class="jFiler-item-others">{{fi-size2}}</span>\
												</div>\
											</div>\
										</div>\
										{{fi-image}}\
									</div>\
									<div class="jFiler-item-assets jFiler-row">\
										<ul class="list-inline pull-left">\
											<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
										</ul>\
										<ul class="list-inline pull-right">\
											<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
										</ul>\
									</div>\
								</div>\
							</div>\
						</li>',
                    progressBar: '<div class="bar"></div>',
                    itemAppendToEnd: false,
                    canvasImage: true,
                    removeConfirmation: true,
                    _selectors: {
                        list: '.jFiler-items-list',
                        item: '.jFiler-item',
                        progressBar: '.bar',
                        remove: '.jFiler-item-trash-action'
                    }
                },
                dragDrop: {
                    dragEnter: null,
                    dragLeave: null,
                    drop: null,
                },

                uploadFile: {
                    url: "/user/musica/" + musicaId + "/anexos/upload",
                    data: fd,
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    synchron: true,
                    beforeSend: function(){},
                    success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id){
                        var parent = itemEl.find(".jFiler-jProgressBar").parent(),
                            new_file_name = data.id,
                            filerKit = inputEl.prop("jFiler");

                        filerKit.files_list[id].name = new_file_name;

                        itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                            $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                    },
                    error: function(el){
                        var parent = el.find(".jFiler-jProgressBar").parent();
                        el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                            $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                    },
                    statusCode: null,
                    onProgress: null,
                    onComplete: null
                },

                files: null,
                addMore: false,
                clipBoardPaste: true,
                excludeName: null,
                beforeRender: null,
                afterRender: null,
                beforeShow: null,
                beforeSelect: null,
                onSelect: null,
                afterShow: null,

                onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
                    var filerKit = inputEl.prop("jFiler"),
                        file_name = filerKit.files_list[id].name;
                    $.post('/user/musica/anexos/remover', {id: file_name, musica : musicaId});
                },

                onEmpty: null,
                options: null,
                dialogs: {
                    alert: function(text) {
                        return alert(text);
                    },
                    confirm: function (text, callback) {
                        confirm(text) ? callback() : null;
                    }
                },
                captions: {
                    button: "Selecione Arquivos",
                    feedback: "Selecione Arquivos para Upload",
                    feedback2: "Arquivos selecionados",
                    drop: "Solte um arquivo aqui para Upload",
                    removeConfirmation: "Are you sure you want to remove this file?",
                    errors: {
                        filesLimit: "Apenas {{fi-limit}} arquivos são permitidos para upload.",
                        filesType: "Only Images are allowed to be uploaded.",
                        filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                        filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                    }
                }
            }
        );

        $("#comentario").emojioneArea({
            autoHideFilters: true,
            autocomplete: true,
            useSprite: true,
        });

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

        $("pre").transpose({key: 'C'});
        $('.c').css('font-size', 12);
        $('.c').css('font-family', 'tahoma');
        $('#content').css('font-size', 12);
        $('#content').css('font-family', 'tahoma');
    }
});