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
                <a className="button is-danger is-inverted is-pulled-right is-small mudarStatus"  onClick={this.props.acao} data-categoria={ this.props.categoria.id }>Inativar</a>
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

    var SelectColecoes = React.createClass({

        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            var _this = this;
            $.get('/user/colecoes/all', function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            if (!this.state.data) {
                this.load();
            }
        },

        render: function () {

            return (
                <div>
                    <label htmlFor="colecao">Cole&ccedil;&atilde;o</label>
                    <select className="input is-primary" ref="colecao" name="colecao" id="colecao" defaultValue={this.props.colecao.id}>

                        { this.state.data.map(function (colecao) {

                            var _this = this;

                            return (
                                <option value={colecao.id} >{_this.props.colecao.id}</option>
                            )
                        })}
                    </select>
                </div>
            )
        }

    });

    var EditarCategoriaModal = React.createClass({
        
        handleSubmit : function (e) {
          
            e.preventDefault();
            
            var id = ReactDOM.findDOMNode(this.refs.id).value.trim;
            var nome = ReactDOM.findDOMNode(this.refs.nome).value.trim;
            var colecao = ReactDOM.findDOMNode(this.refs.colecao).value.trim;

            if (!nome || !colecao) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
            }

            return false;

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
                    _this.loadStatus();
                },
                error: function () {
                    unblock_screen();
                    alertify.error("Ocorreu um erro.");
                }
            });
        },
        
        render: function() {

            console.log(this.props.categoria.colecao);

            var modal = null;
            modal = (
                <Modal title="Categoria" handleSubmit={this.handleSubmit}>
                    <input type="hidden" ref="id" name="id" id="id" />
                    <label htmlFor="nome">Nome</label>
                    <input className="input is-primary" type="text" placeholder="Nome" defaultValue={this.props.categoria.nome} ref="nome" name="nome" id="nome" required/>
                    <SelectColecoes colecao={this.props.categoria.colecao}/>
                </Modal>
            );

            return (
                <div className="scheduleentry-modal">
                    {modal}
                </div>
            );
        }
    });

    var BlockCategorias = React.createClass({

        render: function () {

            var mudarStatus = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = <MudarStatusCategoria categoria={this.props.categoria} reloadCategoria={this.props.reloadCategoria}/>
            }

            return (
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={divStyle}>
                    <div className="card-content">
                        <div className="media">
                            <div className="media-body">
                                <h4 className="media-heading">
                                    <a href={this.props.musicasUrl}>{this.props.categoria.nome}</a>
                                    <BtnEditar categoria={this.props.categoria} acao={this.props.acao}/>
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
                <i>{btnStatus}</i>
            )
        }

    });

    var CategoriasList = React.createClass({
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
                <div>
                <span>{ this.state.data.map(function (categoria) {
                    var musicasUrl = "/user/musicas/" + categoria.id + "/" + categoria.nome;
                    return (
                        <div key={categoria.id}>
                            <BlockCategorias categoria={categoria} musicasUrl={musicasUrl} user={user} reloadCategoria={_this.load} acao={_this.openModal}/>
                            <EditarCategoriaModal categoria={categoria} />
                        </div>
                    )
                }) }</span>

                </div>
            )
        }
    });

    var source = $("#categorias").attr("data-source");
    var user = $("#categorias").attr("data-user");

    ReactDOM.render(
        <div>
            <CategoriasList source={source} user={user}/>
        </div>,
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