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
                React.createElement("a", {className: "button is-white is-pulled-right is-small openMenu", 
                   "data-toggle": "modal", 
                   "data-target": "#myModal", 
                   "data-id":  this.props.colecao.id, 
                   "data-nome":  this.props.colecao.nome, 
                   "data-descricao":  this.props.colecao.nome}, "Editar")
            )
        }

    };

    class BtnInativar extends React.Component{

        render() {
            return (
                React.createElement("a", {className: "button is-danger is-inverted is-pulled-right is-small mudarStatus", onClick: this.props.acao, "data-colecao":  this.props.colecao.id}, "Inativar")
            )
        }

    };

    class BtnAtivar extends React.Component{

        render() {
            return (
                React.createElement("a", {className: "button is-success is-inverted is-pulled-right is-small mudarStatus", onClick: this.props.acao, "data-colecao":  this.props.colecao.id}, "Ativar")
            )
        }

    };

    class Image extends React.Component{
        render() {
            return (
                React.createElement("a", {href: this.props.categoriasUrl}, 
                    React.createElement("img", {className: "img-responsive", style: divStyle, src: this.props.colecao.imagem ? this.props.dirImg + '' + this.props.colecao.imagem : this.props.defaultImage, alt: this.props.colecao.name})
                )
            )
        }
    };

    class Figure extends React.Component{

        render() {

            var mudarStatus = '';

            if (this.props.user == 'ROLE_ADMIN') {
                mudarStatus = React.createElement(MudarStatusColecao, {colecao: this.props.colecao, reloadColecao: this.props.reloadColecao})
            }

            return (
                React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                    React.createElement("div", {className: "img-wrapper"}, 
                        React.createElement(Image, {colecao: this.props.colecao, dirImg: this.props.dirImg, categoriasUrl: this.props.categoriasUrl, defaultImage: this.props.defaultImage})
                    ), 
                    React.createElement("figcaption", null, 
                        React.createElement("h4", null, 
                            React.createElement("a", {href: this.props.categoriasUrl}, 
                                this.props.colecao.nome
                            ), 
                            React.createElement(BtnEditar, {colecao: this.props.colecao}), 
                            mudarStatus
                        )
                    )
                )
            )
        }
    };

    class BlockColecoes extends React.Component{

        render() {

            return (
                React.createElement("div", {className: "col-sm-4 col-xs-12"}, 
                    React.createElement(Figure, {colecao: this.props.colecao, dirImg: this.props.dirImg, categoriasUrl: this.props.categoriasUrl, 
                            defaultImage: this.props.defaultImage, reloadColecao: this.props.reloadColecao, user: this.props.user})
                )
            )
        }
    };

    var MudarStatusColecao = React.createClass({displayName: "MudarStatusColecao",

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
                    url: '/user/colecao/' + colecao.colecao.id,
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
                btnStatus = React.createElement(BtnInativar, {acao: this.handleInativarColecao, colecao: this.props.colecao});
            } else {
                btnStatus = React.createElement(BtnAtivar, {acao: this.handleInativarColecao, colecao: this.props.colecao})
            }

            return (
                React.createElement("i", null, btnStatus)
            )
        }

    });

    var CategoriasList = React.createClass({displayName: "CategoriasList",
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
                React.createElement("span", null,  this.state.data.map(function (categoria) {
                    var musicasUrl = "/user/musicas/" + categoria.id + "/" + categoria.nome;
                    return (
                        React.createElement("div", {key: categoria.id}, 
                            "'Echo'"
                        )
                    )
                }) )
            )
        }
    });

    var source = $("#categorias").attr("data-source");
    var user = $("#categorias").attr("data-user");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(CategoriasList, {source: source, user: user})
        ),
        document.getElementById('categorias')
    );


});