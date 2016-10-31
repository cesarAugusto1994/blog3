/**
 * Created by cesar on 31/10/16.
 */


$(function () {

    class CardHero extends React.Component{
        render() {
            return (
                React.createElement("section", {id: "hero-area"}, 
                    React.createElement("div", {className: "row"}, 
                        React.createElement("div", {className: "col-md-12 text-center"}, 
                            React.createElement("div", {className: "block wow fadeInUp", "data-wow-delay": ".3s"}, 
                                React.createElement("section", {className: "cd-intro"}, 
                                    React.createElement("h1", {className: "wow fadeInUp animated cd-headline slide", "data-wow-delay": ".4s"}, 
                                        React.createElement("span", null, "Olá, ."), React.createElement("br", null)
                                    )
                                ), 
                                React.createElement("h2", {className: "wow fadeInUp animated", "data-wow-delay": ".6s"}, 
                                    "Bem vindo ao"
                                ), 
                                React.createElement("a", {className: "btn-lines dark light wow fadeInUp animated smooth-scroll btn btn-default btn-green", 
                                   "data-wow-delay": ".9s", href: "#works", "data-section": "#works"}, "Iniciar")
                            )
                        )
                    )
                )
            );
        }
    }
   
    class Card extends React.Component{
        render() {
            return (
                React.createElement("section", {id: "works", className: "works"}, 
                    React.createElement("div", {className: "container"}, 
                        React.createElement("div", {className: "section-heading"}, 
                            React.createElement("h1", {className: "title wow fadeInDown", "data-wow-delay": ".3s"}, this.props.sectionName)
                        ), 
                        React.createElement("div", {className: "row"}, 
                            this.props.children
                        )
                    )
                )
            );
        }
    }

    class CardBlue extends React.Component{
        render() {
            return (
                React.createElement("section", {id: "call-to-action"}, 
                    React.createElement("div", {className: "container"}, 
                        React.createElement("div", {className: "col-md-12"}, 
                            React.createElement("div", {className: "block"}, 
                                React.createElement("h2", {className: "title wow fadeInDown", "data-wow-delay": ".3s", 
                                    "data-wow-duration": "500ms"}, this.props.sectionName), 
                                React.createElement("div", {className: "row"}, 
                                    this.props.children
                                )
                            )
                        )
                    )
                )
            );
        }
    }

    const StyleImg = {
        minHeight: '160px',
        maxHeight: '160px',
        margin: 'auto'
    };
    
    var Menu = React.createClass({displayName: "Menu",
       
        getInitialState : function () {
            return {data : []}
        },
        
        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data : result })
            }.bind(this))
        },
        
        componentDidMount : function () {
            this.load();
        },
        
        render : function () {

            var root = '';
            var _this = this;

            return (
                React.createElement("div", null, 
                    React.createElement(Card, {sectionName: "Inicio"}, 
                     this.state.data.map(function (menu) {

                        root = _this.props.dirMenu + menu.icon;

                        return (
                            React.createElement("div", {key: menu.id, className: "col-sm-4 col-xs-12"}, 
                                React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                                    React.createElement("div", {className: "img-wrapper"}, 
                                        React.createElement("a", {href: menu.url}, 
                                            React.createElement("img", {style: StyleImg, src: root, className: "img-responsive", alt: "this is a title"}), 
                                                React.createElement("div", {className: "overlay"})
                                        )
                                    ), 
                                    React.createElement("figcaption", null, 
                                        React.createElement("h4", null, 
                                            React.createElement("a", {href: menu.url}, 
                                                menu.nome
                                            )
                                        ), 
                                        React.createElement("p", null, 
                                            menu.descricao
                                        )
                                    )
                                )
                            )
                        )
                    }) 
                        )
                )
            )
        }
        
    });

    var Colecao = React.createClass({displayName: "Colecao",

        getInitialState : function () {
            return {data : []}
        },

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data : result })
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        render : function () {

            var root = defaultBackground;
            var linkToCategorias = '';
            var _this = this;

            return (
                React.createElement("div", null, 
                    React.createElement(Card, {sectionName: "Coleções"}, 
                         this.state.data.map(function (colecao) {

                            root = colecao.imagem ? _this.props.dirColecao + colecao.imagem : defaultBackground;
                            linkToCategorias = "/user/categorias/" + colecao.id + "/" + colecao.nome;

                            return (
                                React.createElement("div", {key: colecao.id, className: "col-sm-4 col-xs-12"}, 
                                    React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                                        React.createElement("div", {className: "img-wrapper"}, 
                                            React.createElement("a", {href: linkToCategorias}, 
                                                React.createElement("img", {style: StyleImg, src: root, className: "img-responsive", alt: "this is a title"}), 
                                                React.createElement("div", {className: "overlay"})
                                            )
                                        ), 
                                        React.createElement("figcaption", null, 
                                            React.createElement("h4", null, 
                                                React.createElement("a", {href: linkToCategorias}, 
                                                    colecao.nome
                                                )
                                            ), 
                                            React.createElement("p", null, 
                                                colecao.descricao
                                            )
                                        )
                                    )
                                )
                            )
                        }) 
                    )
                )
            )
        }

    });

    var Musica = React.createClass({displayName: "Musica",

        getInitialState : function () {
            return {data : []}
        },

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data : result })
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        render : function () {

            var linkToAnexos = '';

            return (
                React.createElement("div", null, 
                    React.createElement(Card, {sectionName: "Adicionadas Recentemente"}, 
                         this.state.data.map(function (musica) {

                            linkToAnexos = "/user/musica/"+musica.id+"/anexos";

                            return (

                                React.createElement("div", {key: musica.id, className: "col-md-4 col-lg-4 col-xs-12"}, 
                                    React.createElement("div", {className: "media wow fadeInDown animated", "data-wow-duration": "500ms", 
                                         "data-wow-delay": "1800ms"}, 
                                        React.createElement("div", {className: "media-left"}, 
                                            React.createElement("div", {className: "icon"}, 
                                                React.createElement("i", {className: "ion-ios-play"})
                                            )
                                        ), 
                                        React.createElement("div", {className: "media-body"}, 
                                            React.createElement("h4", {className: "media-heading"}, React.createElement("a", {href: linkToAnexos},  musica.nome))
                                        )
                                    )
                                )
                                
                            )
                        }) 
                    )
                )
            )
        }

    });

    var Videos = React.createClass({displayName: "Videos",

        getInitialState : function () {
            return {data : []}
        },

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data : result })
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        render : function () {

            var linkToVideos = '';

            return (
                React.createElement("div", null, 
                    React.createElement(CardBlue, {sectionName: "Videos"}, 
                         this.state.data.map(function (video) {
                            linkToVideos = "/user/videos";
                            return (
                                React.createElement("div", {key: video.id, className: "col-md-4 col-lg-4 col-xs-12"}, 
                                    React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                                        React.createElement("div", {className: "img-wrapper"}, 
                                            React.createElement("iframe", {width: "100%", height: "100%", src: "https://www.youtube.com/embed/{video.link}", 
                                                     frameBorder: "0", allowFullScreen: true})
                                        ), 
                                        React.createElement("figcaption", null, 
                                            React.createElement("h4", null, 
                                                video.nome
                                            )
                                        )
                                    )
                                )
                            )
                        }) 
                    )
                )
            )
        }

    });
    
    var menu = $("#user").data("menu");
    var dirMenu = $("#user").data("dir-menu");
    var colecao = $("#user").data("colecao");
    var dirColecao = $("#user").data("dir-colecao");
    var defaultBackground = $("#user").data("default-background");
    var musica = $("#user").data("musica");
    var videos = $("#user").data("videos");

    ReactDOM.render(
      React.createElement("div", null, 
          React.createElement(CardHero, null), 
          React.createElement(Menu, {source: menu, dirMenu: dirMenu}), 
          React.createElement(Colecao, {source: colecao, dirColecao: dirColecao, defaultBackground: defaultBackground}), 
          React.createElement(Musica, {source: musica}), 
          React.createElement(Videos, {source: videos})
      ),
        document.getElementById('user')
    );
    
});