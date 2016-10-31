/**
 * Created by cesar on 31/10/16.
 */

$(function () {

    const StyleImg = {
        minWidth: '24px',
        maxWidth: '24px',
        minHeight: '24px',
        maxHeight: '24px',
        margin : 'auto'
    };

    const FontLogoStyle = {
        color : "#1e282c"
    };

    class CardMenu extends React.Component{

        render() {
            return (
                React.createElement("header", {id: "top-bar", className: "navbar-fixed-top animated-header"}, 
                    React.createElement("div", {className: "container"}, 
                        this.props.children
                    )
                )
            )
        }
    };

    class NavbarHeader extends React.Component{

        render() {
            return (
                React.createElement("div", {className: "navbar-header"}, 
                    React.createElement("button", {type: "button", className: "navbar-toggle", "data-toggle": "collapse", "data-target": ".navbar-collapse"}, 
                        React.createElement("span", {className: "sr-only"}, "Toggle navigation"), 
                        React.createElement("span", {className: "icon-bar"}), 
                        React.createElement("span", {className: "icon-bar"}), 
                        React.createElement("span", {className: "icon-bar"})
                    ), 

                    React.createElement("div", {className: "navbar-brand"}, 
                        React.createElement("a", {href: "/user/"}, React.createElement("img", {style: StyleImg, alt: "...", src: this.props.configImg}), " ", React.createElement("span", {style: FontLogoStyle}, this.props.configNome))
                    )
                )
            );
        }
    };

    class MainMenu extends React.Component{

        render() {
            return (
                React.createElement("nav", {className: "collapse navbar-collapse navbar-right", role: "navigation"}, 
                    React.createElement("div", {className: "main-menu"}, 
                        React.createElement("ul", {className: "nav navbar-nav navbar-right"}, 
                            this.props.children
                        )
                    )
                )
            )
        }
    };
    
    class Footer extends React.Component{
        render() {
            return (
                React.createElement("footer", {id: "footer"}, 
                    React.createElement("div", {className: "container"}, 
                        React.createElement("div", {className: "col-md-8"}, 
                            React.createElement("p", {className: "copyright"}, "Copyright: ", React.createElement("span", null, "2016"))
                        ), 
                        React.createElement("div", {className: "col-md-4"}
                        )
                    )
                )
            )
        }
    }

    var Menu = React.createClass({displayName: "Menu",

        getInitialState : function () {
          return { data : [] }
        },

        load : function () {
            $.get('/admin/menus', function (result) {
                this.setState({ data : result })
            }.bind(this))
        },

        componentDidMount : function () {
            this.load();
        },

        render : function () {

            var rootAvatar = this.props.dirAvatar + this.props.user.avatar;
            var linkToPerfil = "/user/perfil/" + this.props.user.id;
            var linkToAtividades = "/user/"+this.props.user.id+"/atividades";
            var admin = "";

            if ("ROLE_ADMIN" == user.role) {
                admin = React.createElement("li", {className: "dropdown"}, 
                    React.createElement("a", {href: "#", className: "dropdown-toggle", "data-toggle": "dropdown"}, "Administrador", 
                        React.createElement("span", {className: "caret"})), 
                    React.createElement("div", {className: "dropdown-menu"}, 
                        React.createElement("ul", null, 
                            React.createElement("li", null, React.createElement("a", {href: "/admin/postForm"}, "Novo Post")), 
                            React.createElement("li", null, React.createElement("a", {href: "/admin/posts/grid"}, "Lista Post")), 
                            React.createElement("li", null, React.createElement("a", {href: "/admin/blog"}, "Configurações")), 
                            React.createElement("li", null, React.createElement("a", {href: "/admin/usuarios/list"}, "Usuários"))
                        )
                    )
                )
            };

            var access = {
                label : "logout",
                link : "/admin/logout"
            };
    
            if ("ROLE_USER" == user.roles) {
                 access = {
                    label : "login",
                    link : "/login"
                };
            }

            return (
                React.createElement(MainMenu, null, 
                     this.state.data.map(function(menu) {
                        return (
                            React.createElement("li", {key: menu.id}, React.createElement("a", {href: menu.url}, menu.nome))
                        )
                    }), 
                    admin, 
                    React.createElement("li", {className: "dropdown"}, 
                        React.createElement("a", {href: "#", className: "dropdown-toggle", "data-toggle": "dropdown"}, 
                            React.createElement("img", {style: StyleImg, src: rootAvatar, 
                                 className: "profile-image img-circle"})
                        ), 
                        React.createElement("div", {className: "dropdown-menu"}, 
                            React.createElement("ul", null, 
                                React.createElement("li", null, React.createElement("a", {href: linkToPerfil}, "Perfil")), 
                                React.createElement("li", null, React.createElement("a", {href: linkToAtividades}, "Atividades"))
                            )
                        )
                    ), 
                    React.createElement("li", null, React.createElement("a", {href: this.props.pesquisar}, "Pesquisar")), 
                    React.createElement("li", null, React.createElement("a", {href: access.link}, access.label))
                )
            )
        }
    });

    var Mount = React.createClass({displayName: "Mount",

        render : function () {

            return (
                React.createElement(CardMenu, null, 
                    React.createElement(NavbarHeader, {configNome: this.props.configNome, configImg: this.props.configImg}), 
                        React.createElement(Menu, {user: this.props.user, dirAvatar: this.props.dirAvatar, pesquisar: this.props.pesquisar})
                )
            )
        }
        
    });

    var userId = $("#menu").data("usuario-id");
    var userNome = $("#menu").data("usuario-nome");
    var userRoles = $("#menu").data("usuario-roles");
    var userAvatar = $("#menu").data("usuario-avatar");
    var configNome = $("#menu").data("config-nome");
    var configImg = $("#menu").data("config-img");

    var user = {
        id : userId, nome : userNome, role : userRoles, avatar : userAvatar
    };

    var pesquisar = $("#menu").data("pesquisar");
    var dirAvatar = $("#menu").data("dir-avatar");
    var avatarDefault = $("#menu").data("avatar-default");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(Mount, {user: user, dirAvatar: dirAvatar, avatarDefault: avatarDefault, pesquisar: pesquisar, configNome: configNome, configImg: configImg})
        ),
        document.getElementById("menu")
    )
});