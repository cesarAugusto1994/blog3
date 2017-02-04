/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    const ROLE_ADMIN = 'ROLE_ADMIN';

    var divStyle = {
        width: '100%'
    };

    class BtnEditar extends React.Component {

        render() {

            return (
                <a className="button is-white is-pulled-right is-small"
                   onClick={ this.props.acao }
                   data-id={ this.props.categoria.id }
                   data-nome={ this.props.categoria.nome }
                   data-colecao={ this.props.categoria.colecao.id }>Editar</a>
            )
        }

    };

    class BtnInativar extends React.Component{

        render() {
            return (
                <a className="button is-danger is-inverted is-pulled-right is-small mudarStatus" onClick={this.props.acao} data-categoria={ this.props.categoria.id }>Inativar</a>
            )
        }

    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a className="button is-success is-inverted is-pulled-right is-small mudarStatus" onClick={this.props.acao} data-categoria={ this.props.categoria.id }>Ativar</a>
            )
        }

    };

    class BtnAddCategoria extends React.Component{
        render() {

            const url = "/user/category/new?collection_id=" + this.props.colecao + "collection_name=" + this.props.colecaoNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Nova Categoria</a>
            );
        }
    };

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
                <div id="ModalCategorias" className="modal fade" tabIndex="-1">
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

    const EditarCategoriaModal = React.createClass({

        handleSubmit : function (e) {
          
            e.preventDefault();

            var id = this.refs.id.value.trim();
            var nome = this.refs.nome.value.trim();
            var colecao = this.refs.colecao.value.trim();

            if (!nome || !colecao) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
            }

            const _this = this;

            $.ajax({
                type: "POST",
                url: "/user/category/"+id+"-"+nome+"/edit",
                data : {
                    id : id,
                    nome : nome,
                    colecao : colecao
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadCategoria();
                    _this.props.closeModal();
                    unblock_screen();
                },
                error: function () {
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });
        },
        
        render: function() {

            let modal = null;
            modal = (
                <Modal title="Editar Categoria" handleSubmit={this.handleSubmit}>
                    <input type="hidden" ref="id" name="id" id="id" defaultValue={this.props.categoria.id}/>
                    <label htmlFor="nome">Nome</label>
                    <input className="input is-primary" type="text" placeholder="Nome" defaultValue={this.props.categoria.nome} ref="nome" name="nome" id="nome" required/>
                    <label htmlFor="colecao">Cole&ccedil;&atilde;o</label>
                    <select className="input is-primary" ref="colecao" name="colecao" id="colecao" defaultValue={this.props.categoria.colecao.id}>
                        { this.props.colecoes.map(function (colecao) {
                            return (
                                <option key={colecao.id} value={colecao.id}>{colecao.nome}</option>
                            )
                        })}
                    </select>
                </Modal>
            );

            return (
                <div>
                    {modal}
                </div>
            );
        }
    });

    const BlockCategorias = React.createClass({

        render: function () {

            let mudarStatus = '';
            let editar = '';

            if (this.props.user == ROLE_ADMIN) {
                mudarStatus = <MudarStatusCategoria categoria={this.props.categoria} reloadCategoria={this.props.reloadCategoria}/>
                editar = <BtnEditar categoria={this.props.categoria} acao={this.props.acao}/>
            }

            return (
                <div className="media fadeInUp animated slide" data-wow-delay=".3s">
                    <div className="media-body">
                        <h4 className="media-heading">
                            <a href={this.props.musicasUrl}>{this.props.categoria.nome} <span className="tag is-light">{this.props.categoria.qtde_musicas}</span></a>
                            {editar}
                            {mudarStatus}
                        </h4>
                        <hr/>
                    </div>
                </div>
            )
        }
    });

    const MudarStatusCategoria = React.createClass({

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
                    url: '/api/category/' + categoria.categoria.id + '-' + categoria.categoria.nome + '/change-status',
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
                btnStatus = <BtnInativar acao={this.handleInativarCategoria} categoria={this.props.categoria}/>;
            } else {
                btnStatus = <BtnAtivar acao={this.handleInativarCategoria} categoria={this.props.categoria}/>
            }

            return (
                <e>{btnStatus}</e>
            )
        }

    });

    const CategoriasList = React.createClass({

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get('/api/colecoes', function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            this.load();
        },

        openModal: function () {
            $("#ModalCategorias").modal("show");
        },
        closeModal: function () {
            $("#ModalCategorias").modal("hide");
            $('.modal-body #id').val('');
            $('.modal-body #nome').val('');
            $('.modal-body #colecao').val('');
        },

        render: function () {

            const _this = this;

            return (
                <div>
                <span>{ _this.props.categoria.map(function (categoria) {
                    const musicasUrl = "/user/category/" + categoria.id + "-" + categoria.nome.toLowerCase().replace(/ /g, '_') + "/praises";
                    return (
                        <div key={categoria.id}>

                            <BlockCategorias
                                categoria={categoria}
                                musicasUrl={musicasUrl}
                                user={_this.props.user}
                                reloadCategoria={_this.props.reloadCategoria}
                                acao={_this.openModal}/>

                            <EditarCategoriaModal
                                closeModal={_this.closeModal}
                                reloadCategoria={_this.props.reloadCategoria}
                                colecoes={_this.state.data}
                                categoria={categoria} />
                        </div>
                    )
                }) }</span>

                </div>
            )
        }
    });

    const OpcoesList = React.createClass({

        render : function () {
            return (
                <div>
                    <BtnAddCategoria
                        colecao={this.props.colecao}
                        colecaoNome={this.props.colecaoNome}
                    />
                    <hr className="small" />
                </div>
            );
        }

    });

    const View = React.createClass({

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            const _this = this;
            $.get(_this.props.source, function (result) {
                _this.setState({ data: result });
            }.bind(_this));
        },
        componentDidMount: function() {
            this.load();
        },

        render : function () {

            var opcoes = '';

            if (this.props.user == ROLE_ADMIN) {
                opcoes = <OpcoesList
                    reloadCategoria={this.load}
                    colecao={this.props.colecao}
                    colecaoNome={this.props.colecaoNome}
                />
            }

            return (
                <Base>
                    {opcoes}
                    <CategoriasList categoria={this.state.data} source={this.props.source} user={this.props.user} reloadCategoria={this.load} acao={this.openModal}/>
                </Base>
            );
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

    const source = $("#categorias").attr("data-source");
    const user = $("#categorias").attr("data-user");

    const colecao = $("#categorias").data("colecao");
    const colecaoNome = $("#categorias").data("colecao-nome");

    if (document.getElementById("categorias")) {
        ReactDOM.render(
            <div>
                <View
                    source={source}
                    user={user}
                    colecao={colecao}
                    colecaoNome={colecaoNome}
                />
            </div>,
            document.getElementById('categorias')
        );
    }

});