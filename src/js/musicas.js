/**
 * Created by cesar on 28/10/16.
 */

$(function () {

    class BtnAdd extends React.Component{

        render() {

            return (
                <a onClick={this.props.openModal} className="button is-light is-small">Adicionar Musica</a>
            );
        }

    }

    class BtnEditar extends React.Component{

        render() {
            return (
                <a href={this.props.link} className="button is-info is-inverted is-small is-pulled-right">Editar</a>
            );
        }

    }

    class BtnInativar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-danger is-inverted is-small is-pulled-right">Inativar</a>
            );
        }
    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a onClick={this.props.mudarStatus} className="button is-success is-inverted is-small is-pulled-right">Ativar</a>
            );
        }
    };

    class Card extends React.Component{
        render() {
            return (
                <div className="media wow fadeInUp animated slide"  data-wow-delay=".3s">
                    <div className="media-body">
                        {this.props.children}
                    </div>
                </div>
            )
        }
    }

    var MudarStatusMusica = React.createClass({

        getInitialState : function () {
            return { ativo : this.props.musica.ativo }
        },

        loadStatus : function () {
            this.props.reloadMusica();
            this.setState({ ativo: !this.props.musica.ativo });
        },

        handleMudarStatus : function (e) {

            e.preventDefault();

            var _this = this;

            alertify.confirm("Deseja " + (this.state.ativo ? 'inativar' : 'ativar') + " esta musica?", function () {

                $.ajax({
                    type: 'POST',
                    url: '/user/musicas/' + _this.props.musica.id + '/status',
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

            }).setting("labels", {"ok": "Sim", "cancel": "Cancelar"});

        },

        render : function () {

            var btn = <BtnAtivar mudarStatus={this.handleMudarStatus} />;

            if (this.props.musica.ativo) {
                btn = <BtnInativar mudarStatus={this.handleMudarStatus} />;
            }

            return (
                <span>{btn}</span>
            )
        }

    });

    var ListMusicas = React.createClass({

        render : function () {

            var btnEditar = "";
            var btnMudarStatus = "";
            var _this = this;

            return(
                <div>
                    {
                        this.props.data.map(function (musica) {

                            var linkAnexos = "/user/musica/"+ musica.id +"/anexos";
                            var editarMusica = "/user/musicas/" + musica.id + "/" + musica.nome + "/editar";

                            if ("ROLE_ADMIN" == _this.props.user) {
                                btnEditar = <BtnEditar link={editarMusica}/>;
                                btnMudarStatus = <MudarStatusMusica musica={musica} reloadMusica={_this.props.reloadMusicas}/>;
                            }

                            return (
                                <div key={musica.id}>
                                    <h4 className="media-heading"><a href={linkAnexos}>{musica.nome}</a>
                                        {btnEditar}
                                        {btnMudarStatus}
                                    </h4><hr/>
                                </div>
                            )
                        })
                    }
                </div>
            )
        }
    });

    var View = React.createClass({

        getInitialState : function () {
            return {data: []};
        },

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({data: result});
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        openModal: function () {
            $("#musica-modal").modal("show");
        },

        closeModal: function () {
            $("#musica-modal").modal("hide");
        },

        render : function () {

            var addMusica = '';

            if ("ROLE_ADMIN" == this.props.user) {
                addMusica = <BtnAdd openModal={this.openModal}/>
            }

            return (
                <div>
                    {addMusica}
                    <GerenciarModal closeModal={this.closeModal} reloadMusicas={this.load} colecao={this.props.colecao} categoria={this.props.categoria}/>
                    <hr className="small" />
                    <ListMusicas data={this.state.data} user={this.props.user} reloadMusicas={this.load}/>
                </div>
            )
        }

    });

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
                <div id="musica-modal" className="modal fade" tabIndex="-1">
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

        getInitialState: function () {
            return {data: [], categorias : []}
        },

        load: function () {
            
            $.get('/user/tonalidades', function (result) {
                this.setState({data: result})
            }.bind(this));

            $.get('/user/categorias/' + colecao, function (result) {
                this.setState({categorias: result})
            }.bind(this));

        },

        componentDidMount: function () {
            this.load();
        },

        handleSubmit : function (e) {

            var _this = this;

            e.preventDefault();

            var nome = this.refs.nome.value.trim();
            var numero = this.refs.numero.value.trim();
            var tonalidade = this.refs.tonalidade.value.trim();
            var categoria = $("#musicas").data("categoria");

            if (!nome || !categoria) {
                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "/user/musica/adicionar",
                data : {
                    nome : nome,
                    numero : numero,
                    tonalidade : tonalidade,
                    categoria : categoria
                },
                cache: false,
                success: function (data) {
                    alertify.success(data.message);
                    _this.props.reloadMusicas();
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
                <Modal title="Adicionar Musica" handleSubmit={this.handleSubmit}>
                    <label htmlFor="nome">Nome</label>
                    <input className="input" type="text" ref="nome" name="nome" ref="nome" id="nome" required/>
                    <label htmlFor="numero">N&uacute;mero</label>
                    <input className="input" type="text" name="numero" id="numero" ref="numero" />
                    <label htmlFor="tonalidade">Tonalidade</label>
                    <select className="form-control" name="tonalidade" ref="tonalidade" id="tonalidade">
                        {this.state.data.map(function (tom) {
                            return (
                                <option key={tom}>{tom}</option>
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

    var source = $("#musicas").attr("data-source");
    var sourceLink = $("#musicas").attr("data-add-musica");
    var user = $("#musicas").attr("data-user");
    var colecao = $("#musicas").data("colecao");
    var categoria = $("#musicas").data("categoria");

    ReactDOM.render(
        <div>
            <View source={source} link={sourceLink} user={user} colecao={colecao} categoria={categoria}/>
        </div>,
            document.getElementById('musicas')
    );
});

