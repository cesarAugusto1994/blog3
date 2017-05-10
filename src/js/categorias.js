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

            let url = "/user/category/" + this.props.categoria.id + "-" + this.props.categoria.nome.toLowerCase().replace(/ /g, '_') + "/edit";

            return (
                <a href={url} className="button is-light is-small is-pulled-right">Editar</a>
            )
        }

    }
    ;

    class BtnInativar extends React.Component {

        render() {
            return (
                <a className="button is-danger is-inverted is-small is-pulled-right mudarStatus" onClick={this.props.acao}
                   data-categoria={ this.props.categoria.id }>Inativar</a>
            )
        }

    }
    ;

    class BtnAtivar extends React.Component {

        render() {
            return (
                <a className="button is-success is-inverted is-small is-pulled-right mudarStatus" onClick={this.props.acao}
                   data-categoria={ this.props.categoria.id }>Ativar</a>
            )
        }

    }
    ;

    class BtnAddCategoria extends React.Component {
        render() {

            const url = "/user/category/new?collection_id=" + this.props.colecao + "collection_name=" + this.props.colecaoNome.toLowerCase().replace(/ /g, '_');

            return (
                <a href={url} className="button is-light is-small">Nova Categoria</a>
            );
        }
    }
    ;

    const BlockCategorias = React.createClass({

        render: function () {

            let btns = '';

            if (this.props.user == ROLE_ADMIN) {
                btns = (
                    <div className="control is-grouped is-centered">
                        <p className="control">
                            <MudarStatusCategoria categoria={this.props.categoria}
                                                  reloadCategoria={this.props.reloadCategoria}/>
                        </p>
                        <p className="control">
                            <BtnEditar categoria={this.props.categoria} acao={this.props.acao}/>
                        </p>
                        <p className="control">
                            <span
                                className="tag is-light is-pulled-right">{this.props.categoria.qtde_musicas}</span>
                        </p>
                    </div>
                );
            }

            return (
                <div className="wow fadeInLeft animated portfolio-item">
                    <div className="col-sm-12 col-xs-12">
                        <h4 className="tile">
                            <a href={this.props.musicasUrl}>
                                {this.props.categoria.nome}
                            </a>
                        </h4>
                        {btns}
                    </div>
                </div>
            )
        }
    });

    const MudarStatusCategoria = React.createClass({

        loadStatus: function () {
            this.props.reloadCategoria();
            this.setState({ativo: !this.props.categoria.ativo});
        },

        getInitialState: function () {
            return {ativo: this.props.categoria.ativo}
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

        render: function () {

            const _this = this;

            let btns = '';


            return (
                <div>
                    <figure>{ _this.props.categoria.map(function (categoria) {

                        const musicasUrl = "/user/category/" + categoria.id + "-" + categoria.nome.toLowerCase().replace(/ /g, '_');

                        if (_this.props.user == ROLE_ADMIN) {
                            btns = (<div>
                                    <span className="badge is-pulled-right">{categoria.qtde_musicas}</span>
                                    <MudarStatusCategoria categoria={categoria}
                                                          reloadCategoria={_this.props.reloadCategoria}/>
                                    <BtnEditar categoria={categoria} acao={_this.props.openModal}/>
                                </div>
                            );
                        }

                        return (
                            <figcaption>
                                <a href={musicasUrl} key={categoria.id}>
                                    {categoria.nome}
                                    {btns}
                                </a>
                            </figcaption>
                        )
                    }) }
                    </figure>
                </div>
            )
        }
    });

    const OpcoesList = React.createClass({

        render: function () {
            return (
                <div>
                    <BtnAddCategoria
                        colecao={this.props.colecao}
                        colecaoNome={this.props.colecaoNome}
                    />
                    <hr className="small"/>
                </div>
            );
        }

    });

    const View = React.createClass({

        getInitialState: function () {
            return {data: []};
        },
        load: function () {
            const _this = this;
            $.get(_this.props.source, function (result) {
                _this.setState({data: result});
            }.bind(_this));
        },
        componentDidMount: function () {
            this.load();
        },

        render: function () {

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
                    <CategoriasList categoria={this.state.data} source={this.props.source} user={this.props.user}
                                    reloadCategoria={this.load} acao={this.openModal}/>
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