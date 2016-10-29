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
            return (
                <button onClick={this.props.openModal} className="button is-light is-small">Nova Categoria</button>
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
                <div id="scheduleentry-modal" className="modal fade" tabIndex="-1">
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

    var EditarCategoriaModal = React.createClass({

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
                <Modal title="Categoria" handleSubmit={this.handleSubmit}>
                    <input type="hidden" ref="id" name="id" id="id" defaultValue={this.props.categoria.id}/>
                    <label htmlFor="nome">Nome</label>
                    <input className="input is-primary" type="text" placeholder="Nome" defaultValue={this.props.categoria.nome} ref="nome" name="nome" id="nome" required/>
                    <label htmlFor="colecao">Cole&ccedil;&atilde;o</label>
                    <select className="input is-primary" ref="colecao" name="colecao" id="colecao" defaultValue={this.props.categoria.colecao.id}>
                        { this.props.colecoes.map(function (colecao) {
                            return (
                                <option key={colecao.id} defaultValue={colecao.id}>{colecao.nome}</option>
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

    var NovaCategoriaModal = React.createClass({

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
                <Modal title="Categoria" handleSubmit={this.handleSubmit}>
                    <label htmlFor="nome">Nome</label>
                    <input className="input is-primary" type="text" placeholder="Nome" ref="nome" name="nome" id="nome" required/>
                    <label htmlFor="colecao">Cole&ccedil;&atilde;o</label>
                    <select className="input is-primary" ref="colecao" name="colecao" id="colecao">
                        { this.state.data.map(function (colecao) {
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

    var BlockCategorias = React.createClass({

        render: function () {

            var mudarStatus = '';
            var editar = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = <MudarStatusCategoria categoria={this.props.categoria} reloadCategoria={this.props.reloadCategoria}/>
                editar = <BtnEditar categoria={this.props.categoria} acao={this.props.acao}/>
            }

            return (
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={divStyle}>
                    <div className="card-content">
                        <div className="media">
                            <div className="media-body">
                                <h4 className="media-heading">
                                    <a href={this.props.musicasUrl}>{this.props.categoria.nome}</a>
                                    {editar}
                                    {mudarStatus}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            )
        }
    });

    var MudarStatusCategoria = React.createClass({

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
                btnStatus = <BtnInativar acao={this.handleInativarCategoria} categoria={this.props.categoria}/>;
            } else {
                btnStatus = <BtnAtivar acao={this.handleInativarCategoria} categoria={this.props.categoria}/>
            }

            return (
                <e>{btnStatus}</e>
            )
        }

    });

    var CategoriasList = React.createClass({

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

        render: function () {

            var _this = this;

            return (
                <div>
                <span>{ _this.props.categoria.map(function (categoria) {
                    var musicasUrl = "/user/musicas/" + categoria.id + "/" + categoria.nome;
                    return (
                        <div key={categoria.id}>
                            <BlockCategorias categoria={categoria} musicasUrl={musicasUrl} user={_this.props.user} reloadCategoria={_this.props.reloadCategoria} acao={_this.props.acao}/>
                            <EditarCategoriaModal colecoes={_this.state.data} categoria={categoria} />
                        </div>
                    )
                }) }</span>

                </div>
            )
        }
    });

    var OpcoesList = React.createClass({

        render : function () {
            return (
                <div>
                    <BtnAddCategoria openModal={this.props.acao} />
                    <NovaCategoriaModal reloadCategoria={this.props.reloadCategoria} closeModal={this.props.closeModal}/>
                    <hr className="small" />
                </div>
            );
        }

    });

    var View = React.createClass({

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
                opcoes = <OpcoesList reloadCategoria={this.load} acao={this.openModal} closeModal={this.closeModal} />
            }

            return (
                <div>
                    {opcoes}
                    <CategoriasList categoria={this.state.data} source={this.props.source} user={this.props.user} reloadCategoria={this.load} acao={this.openModal}/>
                </div>
            );
        }
    });

    var source = $("#categorias").attr("data-source");
    var user = $("#categorias").attr("data-user");

    ReactDOM.render(
        <div>
            <View source={source} user={user}/>
        </div>,
        document.getElementById('categorias')
    );


});