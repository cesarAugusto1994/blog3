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

            let editar = "/user/colecao/" + this.props.colecao.id + "-" + this.props.colecao.nome.toLowerCase().replace(/ /g, '_') + "/editar";

            return (
                <a className="button is-primary is-small"
                href={editar}>Editar</a>
            )
        }

    };

    class BtnInativar extends React.Component{

        render() {
            return (
                <a className="button is-danger is-fullwidth is-small mudarStatus"  onClick={this.props.acao} data-colecao={ this.props.colecao.id }>Inativar</a>
            )
        }

    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                <a className="button is-success is-fullwidth is-small mudarStatus" onClick={this.props.acao} data-colecao={ this.props.colecao.id }>Ativar</a>
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

            let mudarStatus = '';
            let editar = '';
            let menu = '';
            let btn = '';

            if (this.props.user == 'ROLE_ADMIN') {

                mudarStatus = <MudarStatusColecao colecao={this.props.colecao} reloadColecao={this.props.reloadColecao}/>
                editar = <BtnEditar colecao={this.props.colecao} />
                btn =  <span className="tag is-light">{this.props.colecao.qtde_categorias}</span>;

                menu = (
                <div className="control is-grouped">

                    <p className="control">
                        {editar}
                    </p>

                    <p className="control">
                        {mudarStatus}
                    </p>

                    <p className="control">
                        {btn}
                    </p>
                </div>
                );
            }

            return (
                <figure className="wow fadeInLeft animated portfolio-item">
                    <div className="img-wrapper" >
                        <Image colecao={this.props.colecao} dirImg={this.props.dirImg} categoriasUrl={this.props.categoriasUrl} defaultImage={this.props.defaultImage}/>
                    </div>
                    <figcaption>
                        <h4>
                            <a href={this.props.categoriasUrl}>
                                {this.props.colecao.nome}
                            </a>
                            {menu}
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

            const _this = this;
            const colecao = this.props;

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

            let btnStatus = '';

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

    const ColecoesList = React.createClass({
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

        render: function () {

            const _this = this;

            return (
                <span>{ this.state.data.map(function (colecao) {
                    let categoriasUrl = "/user/collection/" + colecao.id + "-" + colecao.nome.toLowerCase().replace(/ /g, '_');
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

    const source = $("#colecoes").attr("data-source");
    const dirImg = $("#colecoes").attr("data-img");
    const defaultImage = $("#colecoes").attr("data-defaul-image");
    const user = $("#colecoes").attr("data-user");

    if (document.getElementById("colecoes")) {
        ReactDOM.render(
            <div>
                <ColecoesList source={source} dirImg={dirImg} defaultImage={defaultImage} user={user}/>
            </div>,
            document.getElementById('colecoes')
        );
    }

});