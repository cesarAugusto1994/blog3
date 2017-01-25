/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var divStyle = {
        minHeight: '160px',
        maxHeight: '160px',
        margin: 'auto'
    };

    class BtnEditar extends React.Component {

        render() {
            return (
                <a className="button is-light is-pulled-right is-small openMenu"
                   data-toggle="modal"
                   data-target="#myModal"
                   data-id={ this.props.colecao.id }
                   data-nome={ this.props.colecao.nome }
                   data-descricao={ this.props.colecao.nome }>Editar</a>
            )
        }

    };

    class BtnInativar extends React.Component{

        render() {
            return (
                <a className="button is-danger is-outlined is-pulled-right is-small mudarStatus"  onClick={this.props.acao} data-colecao={ this.props.colecao.id }>Inativar</a>
            )
        }

    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a className="button is-success is-outlined is-pulled-right is-small mudarStatus" onClick={this.props.acao} data-colecao={ this.props.colecao.id }>Ativar</a>
            )
        }

    };

    class Image extends React.Component{
        render() {
            return (
                <a href={this.props.categoriasUrl}>
                    <img className="img-responsive" style={divStyle} src={this.props.colecao.imagem ? this.props.dirImg + '' + this.props.colecao.imagem : this.props.defaultImage } alt={this.props.colecao.name} />
                </a>
            )
        }
    };

    class Figure extends React.Component{

        render() {

            var mudarStatus = '';
            var editar = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = <MudarStatusColecao colecao={this.props.colecao} reloadColecao={this.props.reloadColecao}/>
                editar = <BtnEditar colecao={this.props.colecao} />
            }

            return (
                <figure className="wow fadeInLeft animated portfolio-item" data-wow-duration="500ms" data-wow-delay="0ms">
                    <div className="img-wrapper" >
                        <Image colecao={this.props.colecao} dirImg={this.props.dirImg} categoriasUrl={this.props.categoriasUrl} defaultImage={this.props.defaultImage}/>
                    </div>
                    <figcaption>
                        <h4>
                            <a href={this.props.categoriasUrl}>
                                {this.props.colecao.nome}
                            </a>
                            {editar}
                            {mudarStatus}
                        </h4>
                    </figcaption>
                </figure>
            )
        }
    };

    class BlockColecoes extends React.Component{

        render() {

            return (
                <div className="col-sm-4 col-xs-6">
                    <Figure colecao={this.props.colecao} dirImg={this.props.dirImg} categoriasUrl={this.props.categoriasUrl}
                            defaultImage={this.props.defaultImage} reloadColecao={this.props.reloadColecao} user={this.props.user}/>
                </div>
            )
        }
    };

    var MudarStatusColecao = React.createClass({

        loadStatus : function() {
            this.props.reloadColecao();
            this.setState({ ativo: !this.props.colecao.ativo });
        },

        getInitialState: function() {
            return { ativo: this.props.colecao.ativo }
        },

        handleInativarColecao: function (e) {

            e.preventDefault();

            var _this = this;
            var colecao = this.props;

            alertify.confirm("Deseja " + (this.state.ativo ? 'Inativar' : 'Ativar') + " esta Cole&ccedil;&atilde;o?", function () {

                block_screen();

                $.ajax({
                    type: 'POST',
                    url: '/user/colecao/' + colecao.colecao.id + '/status',
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
                btnStatus = <BtnInativar acao={this.handleInativarColecao} colecao={this.props.colecao}/>;
            } else {
                btnStatus = <BtnAtivar acao={this.handleInativarColecao} colecao={this.props.colecao}/>
            }

            return (
                <e>{btnStatus}</e>
            )
        }

    });

    var ColecoesList = React.createClass({
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

        render: function () {

            var _this = this;
            
            return (
                <span>{ this.state.data.map(function (colecao) {
                    var categoriasUrl = "/user/categorias/" + colecao.id + "/" + colecao.nome;
                    return (
                        <div key={colecao.id}>
                            <BlockColecoes colecao={colecao}
                                           dirImg={dirImg}
                                           categoriasUrl={categoriasUrl}
                                           defaultImage={defaultImage}
                                           reloadColecao={_this.load}
                                           user={user}
                            />
                        </div>
                    )
                }) }</span>
            )
        }
    });

    var source = $("#colecoes").attr("data-source");
    var dirImg = $("#colecoes").attr("data-img");
    var defaultImage = $("#colecoes").attr("data-defaul-image");
    var user = $("#colecoes").attr("data-user");

    if (document.getElementById("colecoes")) {
        ReactDOM.render(
            <div>
                <ColecoesList source={source} dirImg={dirImg} defaultImage={defaultImage} user={user}/>
            </div>,
            document.getElementById('colecoes')
        );
    }

});