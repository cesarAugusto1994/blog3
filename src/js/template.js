/**
 * Created by cesar on 31/10/16.
 */

$(function () {

    const StyleImg = {
        minWidth: '24px',
        maxWidth: '24px',
        minHeight: '24px',
        maxHeight: '24px',
        margin: 'auto'
    };

    const FontLogoStyle = {
        color: "#1e282c"
    };

    class CardMenu extends React.Component {

        render() {
            return (
                <header id="top-bar" className="navbar-fixed-top animated-header">
                    <div className="container">
                        {this.props.children}
                    </div>
                </header>
            )
        }
    }
    ;

    class NavbarHeader extends React.Component {

        render() {
            return (
                <div className="navbar-header">
                    <button type="button" className="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span className="sr-only">Toggle navigation</span>
                        <span className="icon-bar"></span>
                        <span className="icon-bar"></span>
                        <span className="icon-bar"></span>
                    </button>

                    <div className="navbar-brand">
                        <a href="/user/"><img style={StyleImg} alt="..." src={this.props.configImg}/>&nbsp;<span
                            style={FontLogoStyle}>{this.props.configNome}</span></a>
                    </div>
                </div>
            );
        }
    }
    ;

    class MainMenu extends React.Component {

        render() {
            return (
                <nav className="collapse navbar-collapse navbar-right" role="navigation">
                    <div className="main-menu">
                        <ul className="nav navbar-nav navbar-right">
                            {this.props.children}
                        </ul>
                    </div>
                </nav>
            )
        }
    }
    ;

    class Footer extends React.Component {
        render() {
            return (
                <footer id="footer">
                    <div className="container">
                        <div className="col-md-8">
                            <p className="copyright">Copyright: <span>2016</span></p>
                        </div>
                        <div className="col-md-4">
                        </div>
                    </div>
                </footer>
            )
        }
    }

    var Menu = React.createClass({

        getInitialState: function () {
            return {data: []}
        },

        load: function () {
            $.get('/api/menus', function (result) {
                this.setState({data: result})
            }.bind(this))
        },

        componentDidMount: function () {
            this.load();
        },

        render: function () {

            var rootAvatar = this.props.dirAvatar + this.props.user.avatar;
            var linkToPerfil = "/user/" + this.props.user.id + '-' + this.props.user.nome.toLowerCase().replace(/ /g, '_');
            var linkToAtividades = "/user/" + this.props.user.id + "/atividades";
            const favoritos = "/user/favorites";
            let link = "/user/grupo/" + this.props.userGrupoId +  "-" +  this.props.userGrupoNome;
            var admin = "";
            var userProfile = "";

            if ("ROLE_ADMIN" == user.role) {
                admin = <li className="dropdown">
                    <a href="#" className="dropdown-toggle" data-toggle="dropdown">Administrador
                        <span className="caret"></span></a>
                    <div className="dropdown-menu">
                        <ul>
                            <li><a href="/admin/praises/added">M&uacute;sicas Adicionadas</a></li>
                            <li><a href="/user/anexos/sem-vinculo">Arquivos Sem Vinculo</a></li>
                            <li><a href="/user/sugestoes">Sugestões</a></li>
                            <li><a href="/user/palavra/add">Novo Post</a></li>
                            <li><a href="/user/palavra/listagem">Lista Post</a></li>
                            <li><a href="/user/manager/email/criar">Criar Email</a></li>
                            <li><a href="/user/manager/email/listagem">Lista Emails</a></li>
                            <li><a href="/user/manager/acesso">Acesso</a></li>
                            <li><a href="/user/manager/comentarios">Comentarios</a></li>
                            <li><a href="/user/manager/logs">Logs</a></li>
                            <li><a href="/user/grupos">Grupos</a></li>
                            <li><a href="/admin/blog">Configura&ccedil;&otilde;es</a></li>
                            <li><a href="/admin/usuarios/list">Usu&aacute;rios</a></li>
                        </ul>
                    </div>
                </li>
            }
            ;

            var access = {
                label: "login",
                link: "/login"
            };

            if ($.inArray(user.role, ["ROLE_USER", "ROLE_ADMIN"]) !== -1) {
                access = {
                    label: "logout",
                    link: "/admin/logout"
                };

                userProfile = <li className="dropdown">
                    <a href="#" className="dropdown-toggle" data-toggle="dropdown">
                        <img style={StyleImg} src={rootAvatar}
                             className="profile-image img-circle"/>&nbsp;&nbsp;{user.nome}
                    </a>
                    <div className="dropdown-menu">
                        <ul>
                            <li><a href={linkToPerfil}>Perfil</a></li>
                            <li><a href={favoritos}>Favoritos</a></li>
                            <li><a href={link}>Meu Grupo</a></li>
                            <li><a href="/user/grupos">Grupos</a></li>
                            <li><a href="/user/playlists">Minhas Playlists</a></li>
                            <li><a href={linkToAtividades}>Atividades</a></li>
                        </ul>
                    </div>
                </li>
            }

            return (
                <MainMenu>
                    <li className="dropdown">
                        <a href="#" className="dropdown-toggle" data-toggle="dropdown">Menu
                            <span className="caret"></span></a>
                        <div className="dropdown-menu">
                            <ul>
                                { this.state.data.map(function (menu) {
                                    return (
                                        <li key={menu.id}><a href={ "/user/" + menu.url}>{menu.nome}</a></li>
                                    )
                                }) }
                            </ul>
                        </div>
                    </li>
                    {admin}
                    {userProfile}
                    <li><a href={this.props.pesquisar}>Pesquisar</a></li>
                    <li><a href={access.link}>{access.label}</a></li>
                </MainMenu>
            )
        }
    });

    var Mount = React.createClass({

        render: function () {

            return (
                <CardMenu>
                    <NavbarHeader configNome={this.props.configNome} configImg={this.props.configImg}/>
                    <Menu user={this.props.user} dirAvatar={this.props.dirAvatar}
                          userGrupoId={this.props.userGrupoId}
                          userGrupoNome={this.props.userGrupoNome}
                          avatarDefault={this.props.avatarDefault} pesquisar={this.props.pesquisar}/>
                </CardMenu>
            )
        }

    });

    var userId = $("#menu").data("usuario-id");
    var userNome = $("#menu").data("usuario-nome");
    var userRoles = $("#menu").data("usuario-roles");
    var userAvatar = $("#menu").data("usuario-avatar");
    var userGrupoId = $("#menu").data("usuario-grupo-id");
    var userGrupoNome = $("#menu").data("usuario-grupo-nome");

    var configNome = $("#menu").data("config-nome");
    var configImg = $("#menu").data("config-img");

    var user = {
        id: userId, nome: userNome, role: userRoles, avatar: userAvatar
    };

    var pesquisar = $("#menu").data("pesquisar");
    var dirAvatar = $("#menu").data("dir-avatar");
    var avatarDefault = $("#menu").data("avatar-default");

    if (document.getElementById("menu")) {
        ReactDOM.render(
            <div>
                <Mount user={user} dirAvatar={dirAvatar} avatarDefault={avatarDefault} pesquisar={pesquisar}
                       userGrupoId={userGrupoId} userGrupoNome={userGrupoNome}
                       configNome={configNome} configImg={configImg}/>
            </div>,
            document.getElementById("menu")
        )
    }
});