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
                <div id="album-modal" className="modal fade" tabIndex="-1">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                                <h4 className="modal-title">{this.props.title}</h4>
                            </div>
                            <form className="form-horizontal" onSubmit={this.props.handleSubmit}>
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

    var GerenciarModal = React.createClass({

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
                <Modal title="Adicionar Album" handleSubmit={this.handleSubmit}>
                    <label htmlFor="nome">Nome</label>
                    <input className="input" type="text" ref="nome" name="nome" ref="nome" id="nome" required/>
                    <label htmlFor="imagem">Imagem</label>
                    <input className="input" type="file" name="imagem" id="imagem" ref="imagem" />
                    <label htmlFor="categoria">Categoria</label>
                    <select className="form-control" name="categoria" ref="categoria" id="categoria">
                        <option value="">Sem Categoria</option>
                        {this.state.data.map(function (categoria) {
                            return (
                                <option key={categoria.id} value={categoria.id}>{categoria.nome}</option>
                            )
                        })}
                    </select>
                    <label htmlFor="musicas">Musicas</label>
                    <input className="input" type="file" multiple name="musicas" id="musicas" ref="musicas" />
                </Modal>
            );

            return (
                <div>
                    {modal}
                </div>
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
                <a className="button is-light is-pulled-right is-small openMenu"
                   data-toggle="modal"
                   data-target="#myModal"
                   data-id={ this.props.album.id }
                   data-nome={ this.props.album.label }>Editar</a>
            )
        }

    };

    class Image extends React.Component{
        render() {
            return (
                <a>
                    <img className="img-responsive img-rounded" style={divStyle} src={this.props.album.imagem ? this.props.dirImg + this.props.album.imagem : this.props.defaultImage } alt={this.props.album.label} />
                </a>
            )
        }
    };

    class Figure extends React.Component{

        render() {

            var editar = '';

            if (this.props.user == 'ROLE_ADMIN') {
                editar = <BtnEditar album={this.props.album} />
            }

            return (
                <figure className="wow fadeInLeft animated portfolio-item" data-wow-duration="500ms" data-wow-delay="0ms">
                    <div className="img-wrapper" >
                        <Image album={this.props.album} dirImg={this.props.dirImg} defaultImage={this.props.defaultImage}/>
                    </div>
                    <figcaption>
                        <h4>
                            <a>
                                {this.props.album.label}
                            </a>
                        </h4>
                    </figcaption>
                </figure>
            )
        }
    };

    class BlockColecoes extends React.Component{

        render() {

            return (
                <div className="col-sm-4 col-xs-12">
                    <Figure album={this.props.album} dirImg={this.props.dirImg}
                            defaultImage={this.props.defaultImage} reloadColecao={this.props.reloadColecao} user={this.props.user}/>
                </div>
            )
        }
    };

    var AlbunsList = React.createClass({

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
                <div>

                    <button onClick={this.openModal} className="button is-primary is-small">Adicionar Album</button>
                    <hr className="small"/>
                    <GerenciarModal reloadAlbuns={this.load} closeModal={this.closeModal}/>

                    { this.state.data.map(function (album) {
                    return (
                        <div key={album.id}>
                            <BlockColecoes album={album}
                                           dirImg={dirImg}
                                           defaultImage={defaultImage}
                                           reloadColecao={this.load}
                                           user={user}
                            />
                        </div>
                    )
                }) }</div>
            )
        }
    });

    var source = $("#albuns").attr("data-source");
    var dirImg = $("#albuns").attr("data-img");
    var defaultImage = $("#albuns").attr("data-defaul-image");
    var user = $("#albuns").attr("data-user");

    ReactDOM.render(
        <div>
            <AlbunsList source={source} dirImg={dirImg} defaultImage={defaultImage} user={user}/>
        </div>,
        document.getElementById('albuns')
    );


});