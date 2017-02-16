/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	__webpack_require__(1);
	__webpack_require__(2);
	__webpack_require__(3);
	__webpack_require__(4);
	__webpack_require__(5);
	__webpack_require__(6);
	__webpack_require__(7);
	__webpack_require__(8);
	__webpack_require__(9);
	__webpack_require__(10);
	__webpack_require__(11);
	__webpack_require__(12);
	__webpack_require__(13);
	__webpack_require__(14);
	__webpack_require__(15);
	module.exports = __webpack_require__(16);


/***/ },
/* 1 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 01/02/17.
	 */

	const StyleForm = {
	    backgroundColor: "transparent"
	};

	class BASE extends React.Component {
	    render() {
	        return React.createElement(
	            "section",
	            { id: "hero-area" },
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-md-12 text-center" },
	                        React.createElement(
	                            "div",
	                            { className: "block wow fadeInUp", "data-wow-delay": ".3s" },
	                            React.createElement(
	                                "section",
	                                { className: "cd-intro" },
	                                React.createElement(
	                                    "div",
	                                    { className: "login-box" },
	                                    React.createElement(
	                                        "div",
	                                        { className: "login-logo text-black" },
	                                        React.createElement(
	                                            "a",
	                                            { href: "/" },
	                                            React.createElement(
	                                                "b",
	                                                null,
	                                                this.props.app
	                                            )
	                                        )
	                                    ),
	                                    React.createElement(
	                                        "div",
	                                        { className: "login-box-body", style: StyleForm },
	                                        React.createElement(
	                                            "p",
	                                            { className: "login-box-msg" },
	                                            "Entre para iniciar a sess\xE3o"
	                                        ),
	                                        this.props.children
	                                    )
	                                )
	                            )
	                        )
	                    )
	                )
	            )
	        );
	    }
	}
	;

	const Form = React.createClass({
	    displayName: "Form",


	    handleSubmit: function (e) {

	        var email = this.refs._username.value;
	        var password = this.refs._password.value;

	        if (!email) {
	            $("#email").focus();
	            $("#email").addClass("is-danger");
	            alertify.error("Deve Informar o E-mail");
	            return false;
	        }

	        $("#email").removeClass("is-danger");

	        if (!password) {
	            $("#password").focus();
	            $("#password").addClass("is-danger");
	            alertify.error("Deve Informar uma senha");
	            return false;
	        }

	        $("#password").removeClass("is-danger");
	        $("#btnSubmit").addClass("is-loading");

	        return true;
	    },

	    render: function () {

	        let error = '';

	        if (this.props.error) {
	            error = React.createElement(
	                "div",
	                { className: "notification is-danger" },
	                React.createElement("button", { className: "delete" }),
	                this.props.error
	            );
	        }

	        return React.createElement(
	            "form",
	            { method: "post", action: this.props.post, onSubmit: this.handleSubmit },
	            error,
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback" },
	                React.createElement("input", { type: "email", name: "_username", autoFocus: "autoFocus",
	                    className: "form-control", placeholder: "E-mail", ref: "_username", required: "required", defaultValue: this.props.lastUserName }),
	                React.createElement("span", { className: "glyphicon glyphicon-envelope form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback" },
	                React.createElement("input", { type: "password", name: "_password", className: "form-control",
	                    placeholder: "Password", required: "required", title: "Informe a Senha", ref: "_password" }),
	                React.createElement("span", { className: "glyphicon glyphicon-lock form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "row" },
	                React.createElement(
	                    "div",
	                    { className: "col-xs-6" },
	                    React.createElement(
	                        "a",
	                        { href: "register", className: "button is-primary is-outlined is-fullwidth" },
	                        "Registrar"
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "col-xs-6" },
	                    React.createElement(
	                        "button",
	                        { type: "submit", className: "button is-success is-outlined is-fullwidth" },
	                        "Entrar"
	                    )
	                )
	            )
	        );
	    }
	});

	const Render = React.createClass({
	    displayName: "Render",


	    render: function () {
	        return React.createElement(
	            BASE,
	            { app: this.props.app },
	            React.createElement(Form, { post: this.props.post, error: this.props.error, lastUserName: this.props.lastUserName })
	        );
	    }
	});

	if (document.getElementById('login')) {

	    const app = $("#login").data("app");
	    const post = $("#login").data("post");
	    const error = $("#login").data("error");
	    const lastUserName = $("#login").data("last-user-name");

	    $(document).on('click', '.notification > button.delete', function () {
	        $(this).parent().addClass('is-hidden');
	        return false;
	    });

	    ReactDOM.render(React.createElement(Render, { app: app, post: post, error: error, lastUserName: lastUserName }), document.getElementById('login'));
	}

/***/ },
/* 2 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 03/11/16.
	 */

	var style = {
	    padding: "0",
	    backgroundImage: 'url(' + $("#register").data("dir-img") + $("#register").data("background") + ')'
	};

	const StyleForm = {
	    backgroundColor: "transparent"
	};

	var Register = React.createClass({
	    displayName: "Register",


	    render: function () {

	        return React.createElement(
	            "section",
	            { id: "hero-area" },
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-md-12 text-center" },
	                        React.createElement(
	                            "div",
	                            { className: "block wow fadeInUp", "data-wow-delay": ".3s" },
	                            React.createElement(
	                                "section",
	                                { className: "cd-intro" },
	                                React.createElement(
	                                    "div",
	                                    { className: "login-box" },
	                                    React.createElement(
	                                        "div",
	                                        { className: "login-logo" },
	                                        React.createElement(
	                                            "a",
	                                            { href: "/" },
	                                            React.createElement(
	                                                "b",
	                                                null,
	                                                this.props.app
	                                            )
	                                        )
	                                    ),
	                                    React.createElement(
	                                        "div",
	                                        { className: "register-box-body", style: StyleForm },
	                                        React.createElement(
	                                            "p",
	                                            { className: "login-box-msg" },
	                                            "Registrar novo usu\xE1rio"
	                                        ),
	                                        React.createElement(FormRegister, null)
	                                    )
	                                )
	                            )
	                        )
	                    )
	                )
	            )
	        );
	    }
	});

	var FormRegister = React.createClass({
	    displayName: "FormRegister",


	    handleForm: function (e) {

	        e.preventDefault();

	        var nome = this.refs.nome.value;
	        var email = this.refs.email.value;
	        var password = this.refs.password.value;
	        var password_confirm = this.refs.password_confirm.value;

	        if (!nome) {
	            $("#nome").focus();
	            $("#nome").addClass("is-danger");
	            alertify.error("Deve Informar o seu Nome");
	            return false;
	        }

	        $("#nome").removeClass("is-danger");

	        if (!email) {
	            $("#email").focus();
	            $("#email").addClass("is-danger");
	            alertify.error("Deve Informar o E-mail");
	            return false;
	        }

	        $("#email").removeClass("is-danger");

	        if (!password) {
	            $("#password").focus();
	            $("#password").addClass("is-danger");
	            alertify.error("Deve Informar uma senha");
	            return false;
	        }

	        $("#password").removeClass("is-danger");

	        if (password != password_confirm) {
	            $("#password").addClass("is-danger");
	            $("#password_confirm").addClass("is-danger");
	            alertify.error("As Senhas n&atilde;o s&atilde;o iguais.");
	            return false;
	        }

	        $("#password").removeClass("is-danger");
	        $("#password_confirm").removeClass("is-danger");

	        $("#btnSubmit").addClass("is-loading");

	        block_screen();

	        $.ajax({
	            type: 'POST',
	            url: "/register/save",
	            data: $("#form").serialize(),
	            cache: false,
	            success: function (data) {

	                $.ajax({
	                    type: 'POST',
	                    url: "/admin/login_check",
	                    data: {
	                        _username: email,
	                        _password: password
	                    },
	                    cache: false,
	                    success: function (data) {
	                        window.location.href = '/user/';
	                        return false;
	                    },
	                    error: function () {
	                        unblock_screen();
	                        $("#btnSubmit").removeClass("is-loading");
	                        alertify.error("opss, algo deu errado...");
	                        return false;
	                    }
	                });
	            },
	            error: function () {
	                unblock_screen();
	                $("#btnSubmit").removeClass("is-loading");
	                alertify.error("opss, algo deu errado...");
	            }
	        });
	    },

	    handlePassLength: function () {

	        if (0 < this.refs.password.value.length && 6 > this.refs.password.value.length) {
	            $("#password").addClass("is-danger");
	            $("#div-password > .help").text("Sua Senha deve conter mais de 6 caracteres.");
	        } else {
	            $("#password").removeClass("is-danger");
	            $("#password").addClass("is-success");
	            $("#div-password > .help").text("");
	        }
	    },

	    handleConfirmPass: function () {

	        if (this.refs.password_confirm.value != this.refs.password.value) {
	            $("#password_confirm").addClass("is-danger");
	        } else {
	            $("#password_confirm").removeClass("is-danger");
	            $("#password_confirm").addClass("is-success");
	        }
	    },

	    render: function () {

	        return React.createElement(
	            "form",
	            { onSubmit: this.handleForm, method: "post", id: "form" },
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback" },
	                React.createElement("input", { className: "input", type: "text", name: "nome", placeholder: "Nome Completo", id: "nome", ref: "nome" }),
	                React.createElement("span", { className: "glyphicon glyphicon-user form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback" },
	                React.createElement("input", { className: "input", type: "text", name: "email", placeholder: "E-mail", id: "email", ref: "email" }),
	                React.createElement("span", { className: "glyphicon glyphicon-envelope form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback", id: "div-password" },
	                React.createElement("input", { className: "input", type: "password", name: "password", onChange: this.handlePassLength, placeholder: "Senha", id: "password",
	                    ref: "password" }),
	                React.createElement("span", { className: "help is-danger" }),
	                React.createElement("span", { className: "glyphicon glyphicon-log-in form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "form-group has-feedback", id: "div-password-confirm" },
	                React.createElement("input", { className: "input", type: "password", name: "password_confirm", onChange: this.handleConfirmPass, placeholder: "Confirme a senha",
	                    id: "password_confirm", ref: "password_confirm" }),
	                React.createElement("span", { className: "glyphicon glyphicon-log-in form-control-feedback" })
	            ),
	            React.createElement(
	                "div",
	                { className: "row" },
	                React.createElement(
	                    "div",
	                    { className: "col-xs-6" },
	                    React.createElement(
	                        "a",
	                        { href: "login", className: "button is-primary is-link is-fullwidth" },
	                        "J\xE1 possuo Conta!"
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "col-xs-6" },
	                    React.createElement(
	                        "button",
	                        { type: "submit", id: "btnSubmit", className: "button is-success is-outlined is-fullwidth" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }

	});

	var background = $("#register").data("background");
	var dirImg = $("#register").data("dir-img");
	var app = $("#register").data("app");

	if (document.getElementById("register")) {
	    ReactDOM.render(React.createElement(
	        "div",
	        null,
	        React.createElement(Register, { app: app })
	    ), document.getElementById("register"));
	}

/***/ },
/* 3 */
/***/ function(module, exports) {

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
	            return React.createElement(
	                'header',
	                { id: 'top-bar', className: 'navbar-fixed-top animated-header' },
	                React.createElement(
	                    'div',
	                    { className: 'container' },
	                    this.props.children
	                )
	            );
	        }
	    };

	    class NavbarHeader extends React.Component {

	        render() {
	            return React.createElement(
	                'div',
	                { className: 'navbar-header' },
	                React.createElement(
	                    'button',
	                    { type: 'button', className: 'navbar-toggle', 'data-toggle': 'collapse',
	                        'data-target': '.navbar-collapse' },
	                    React.createElement(
	                        'span',
	                        { className: 'sr-only' },
	                        'Toggle navigation'
	                    ),
	                    React.createElement('span', { className: 'icon-bar' }),
	                    React.createElement('span', { className: 'icon-bar' }),
	                    React.createElement('span', { className: 'icon-bar' })
	                ),
	                React.createElement(
	                    'div',
	                    { className: 'navbar-brand' },
	                    React.createElement(
	                        'a',
	                        { href: '/user/' },
	                        React.createElement('img', { style: StyleImg, alt: '...', src: this.props.configImg }),
	                        '\xA0',
	                        React.createElement(
	                            'span',
	                            {
	                                style: FontLogoStyle },
	                            this.props.configNome
	                        )
	                    )
	                )
	            );
	        }
	    }
	    ;

	    class MainMenu extends React.Component {

	        render() {
	            return React.createElement(
	                'nav',
	                { className: 'collapse navbar-collapse navbar-right', role: 'navigation' },
	                React.createElement(
	                    'div',
	                    { className: 'main-menu' },
	                    React.createElement(
	                        'ul',
	                        { className: 'nav navbar-nav navbar-right' },
	                        this.props.children
	                    )
	                )
	            );
	        }
	    }
	    ;

	    class Footer extends React.Component {
	        render() {
	            return React.createElement(
	                'footer',
	                { id: 'footer' },
	                React.createElement(
	                    'div',
	                    { className: 'container' },
	                    React.createElement(
	                        'div',
	                        { className: 'col-md-8' },
	                        React.createElement(
	                            'p',
	                            { className: 'copyright' },
	                            'Copyright: ',
	                            React.createElement(
	                                'span',
	                                null,
	                                '2016'
	                            )
	                        )
	                    ),
	                    React.createElement('div', { className: 'col-md-4' })
	                )
	            );
	        }
	    }

	    var Menu = React.createClass({
	        displayName: 'Menu',


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get('/api/menus', function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var rootAvatar = this.props.dirAvatar + this.props.user.avatar;
	            var linkToPerfil = "/user/" + this.props.user.id + '/' + this.props.user.nome.toLowerCase().replace(/ /g, '_') + '/perfil';
	            var linkToAtividades = "/user/" + this.props.user.id + "/atividades";
	            const favoritos = "/user/favorites";
	            var admin = "";
	            var userProfile = "";

	            if ("ROLE_ADMIN" == user.role) {
	                admin = React.createElement(
	                    'li',
	                    { className: 'dropdown' },
	                    React.createElement(
	                        'a',
	                        { href: '#', className: 'dropdown-toggle', 'data-toggle': 'dropdown' },
	                        'Administrador',
	                        React.createElement('span', { className: 'caret' })
	                    ),
	                    React.createElement(
	                        'div',
	                        { className: 'dropdown-menu' },
	                        React.createElement(
	                            'ul',
	                            null,
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: '/admin/praises/added' },
	                                    'Musicas Adicionadas'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: '/admin/post/form' },
	                                    'Novo Post'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: '/admin/posts/grid' },
	                                    'Lista Post'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: '/admin/blog' },
	                                    'Configura\xE7\xF5es'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: '/admin/usuarios/list' },
	                                    'Usu\xE1rios'
	                                )
	                            )
	                        )
	                    )
	                );
	            };

	            var access = {
	                label: "login",
	                link: "/login"
	            };

	            if ($.inArray(user.role, ["ROLE_USER", "ROLE_ADMIN"]) !== -1) {
	                access = {
	                    label: "logout",
	                    link: "/admin/logout"
	                };
	                userProfile = React.createElement(
	                    'li',
	                    { className: 'dropdown' },
	                    React.createElement(
	                        'a',
	                        { href: '#', className: 'dropdown-toggle', 'data-toggle': 'dropdown' },
	                        React.createElement('img', { style: StyleImg, src: rootAvatar,
	                            className: 'profile-image img-circle' }),
	                        '\xA0\xA0',
	                        user.nome
	                    ),
	                    React.createElement(
	                        'div',
	                        { className: 'dropdown-menu' },
	                        React.createElement(
	                            'ul',
	                            null,
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: linkToPerfil },
	                                    'Perfil'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: favoritos },
	                                    'Favoritos'
	                                )
	                            ),
	                            React.createElement(
	                                'li',
	                                null,
	                                React.createElement(
	                                    'a',
	                                    { href: linkToAtividades },
	                                    'Atividades'
	                                )
	                            )
	                        )
	                    )
	                );
	            }

	            return React.createElement(
	                MainMenu,
	                null,
	                this.state.data.map(function (menu) {
	                    return React.createElement(
	                        'li',
	                        { key: menu.id },
	                        React.createElement(
	                            'a',
	                            { href: "/user/" + menu.url },
	                            menu.nome
	                        )
	                    );
	                }),
	                admin,
	                userProfile,
	                React.createElement(
	                    'li',
	                    null,
	                    React.createElement(
	                        'a',
	                        { href: this.props.pesquisar },
	                        'Pesquisar'
	                    )
	                ),
	                React.createElement(
	                    'li',
	                    null,
	                    React.createElement(
	                        'a',
	                        { href: access.link },
	                        access.label
	                    )
	                )
	            );
	        }
	    });

	    var Mount = React.createClass({
	        displayName: 'Mount',


	        render: function () {

	            return React.createElement(
	                CardMenu,
	                null,
	                React.createElement(NavbarHeader, { configNome: this.props.configNome, configImg: this.props.configImg }),
	                React.createElement(Menu, { user: this.props.user, dirAvatar: this.props.dirAvatar, avatarDefault: this.props.avatarDefault, pesquisar: this.props.pesquisar })
	            );
	        }

	    });

	    var userId = $("#menu").data("usuario-id");
	    var userNome = $("#menu").data("usuario-nome");
	    var userRoles = $("#menu").data("usuario-roles");
	    var userAvatar = $("#menu").data("usuario-avatar");

	    var configNome = $("#menu").data("config-nome");
	    var configImg = $("#menu").data("config-img");

	    var user = {
	        id: userId, nome: userNome, role: userRoles, avatar: userAvatar
	    };

	    var pesquisar = $("#menu").data("pesquisar");
	    var dirAvatar = $("#menu").data("dir-avatar");
	    var avatarDefault = $("#menu").data("avatar-default");

	    if (document.getElementById("menu")) {
	        ReactDOM.render(React.createElement(
	            'div',
	            null,
	            React.createElement(Mount, { user: user, dirAvatar: dirAvatar, avatarDefault: avatarDefault, pesquisar: pesquisar,
	                configNome: configNome, configImg: configImg })
	        ), document.getElementById("menu"));
	    }
	});

/***/ },
/* 4 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 31/10/16.
	 */

	$(function () {

	    class CardHero extends React.Component {
	        render() {
	            return React.createElement(
	                "section",
	                { id: "hero-area" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-md-12 text-center" },
	                        React.createElement(
	                            "div",
	                            { className: "block wow fadeInUp" },
	                            React.createElement(
	                                "section",
	                                { className: "cd-intro" },
	                                React.createElement(
	                                    "h1",
	                                    { className: "wow fadeInUp animated cd-headline slide", "data-wow-delay": ".2s" },
	                                    React.createElement(
	                                        "span",
	                                        null,
	                                        "Ol\xE1, ",
	                                        this.props.user,
	                                        "."
	                                    ),
	                                    React.createElement("br", null)
	                                )
	                            ),
	                            React.createElement(
	                                "div",
	                                { className: "container is-half" },
	                                React.createElement(
	                                    "h2",
	                                    { className: "wow fadeInUp animated", "data-wow-delay": ".2s" },
	                                    this.props.app
	                                )
	                            ),
	                            React.createElement(
	                                "a",
	                                { className: "btn-lines dark light wow fadeInUp animated smooth-scroll btn btn-default btn-green",
	                                    "data-wow-delay": ".3s", href: "#works", "data-section": "#works" },
	                                "Iniciar"
	                            )
	                        )
	                    )
	                )
	            );
	        }
	    }

	    class Card extends React.Component {
	        render() {
	            return React.createElement(
	                "section",
	                { id: "works", className: "works" },
	                React.createElement(
	                    "div",
	                    { className: "container" },
	                    React.createElement(
	                        "div",
	                        { className: "section-heading" },
	                        React.createElement(
	                            "h1",
	                            { className: "title wow fadeInDown", "data-wow-delay": ".1s" },
	                            this.props.sectionName
	                        )
	                    ),
	                    React.createElement(
	                        "div",
	                        { className: "row" },
	                        this.props.children
	                    )
	                )
	            );
	        }
	    }

	    class CardBlue extends React.Component {
	        render() {
	            return React.createElement(
	                "section",
	                { id: "call-to-action" },
	                React.createElement(
	                    "div",
	                    { className: "container" },
	                    React.createElement(
	                        "div",
	                        { className: "col-md-12" },
	                        React.createElement(
	                            "div",
	                            { className: "block" },
	                            React.createElement(
	                                "h2",
	                                { className: "title wow fadeInDown", "data-wow-delay": ".1s" },
	                                this.props.sectionName
	                            ),
	                            React.createElement(
	                                "div",
	                                { className: "row" },
	                                this.props.children
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

	    var Menu = React.createClass({
	        displayName: "Menu",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get(this.props.source, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var root = '';
	            var _this = this;

	            return React.createElement(
	                "div",
	                null,
	                React.createElement(
	                    Card,
	                    { sectionName: "Inicio" },
	                    this.state.data.map(function (menu) {

	                        root = _this.props.dirMenu + menu.icon;

	                        return React.createElement(
	                            "div",
	                            { key: menu.id, className: "col-sm-4 col-xs-12" },
	                            React.createElement(
	                                "figure",
	                                { className: "wow fadeInLeft animated portfolio-item" },
	                                React.createElement(
	                                    "div",
	                                    { className: "img-wrapper" },
	                                    React.createElement(
	                                        "a",
	                                        { href: menu.url },
	                                        React.createElement("img", { style: StyleImg, src: root, className: "img-responsive", alt: "this is a title" }),
	                                        React.createElement("div", { className: "overlay" })
	                                    )
	                                ),
	                                React.createElement(
	                                    "figcaption",
	                                    null,
	                                    React.createElement(
	                                        "h4",
	                                        null,
	                                        React.createElement(
	                                            "a",
	                                            { href: menu.url },
	                                            menu.nome
	                                        )
	                                    ),
	                                    React.createElement(
	                                        "p",
	                                        null,
	                                        menu.descricao
	                                    )
	                                )
	                            )
	                        );
	                    })
	                )
	            );
	        }

	    });

	    var Colecao = React.createClass({
	        displayName: "Colecao",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get(this.props.source, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var root = defaultBackground;
	            var linkToCategorias = '';
	            var _this = this;

	            return React.createElement(
	                "div",
	                null,
	                React.createElement(
	                    Card,
	                    { sectionName: "Cole\xE7\xF5es" },
	                    this.state.data.map(function (colecao) {

	                        root = colecao.imagem ? _this.props.dirColecao + colecao.imagem : defaultBackground;
	                        linkToCategorias = "/user/collection/" + colecao.id + "-" + colecao.nome.toLowerCase().replace(/ /g, '_') + "/categories";

	                        return React.createElement(
	                            "div",
	                            { key: colecao.id, className: "col-sm-4 col-xs-12" },
	                            React.createElement(
	                                "figure",
	                                { className: "wow fadeInLeft animated portfolio-item" },
	                                React.createElement(
	                                    "div",
	                                    { className: "img-wrapper" },
	                                    React.createElement(
	                                        "a",
	                                        { href: linkToCategorias },
	                                        React.createElement("img", { style: StyleImg, src: root, className: "img-responsive", alt: "this is a title" }),
	                                        React.createElement("div", { className: "overlay" })
	                                    )
	                                ),
	                                React.createElement(
	                                    "figcaption",
	                                    null,
	                                    React.createElement(
	                                        "h4",
	                                        null,
	                                        React.createElement(
	                                            "a",
	                                            { href: linkToCategorias },
	                                            colecao.nome
	                                        )
	                                    ),
	                                    React.createElement(
	                                        "p",
	                                        null,
	                                        colecao.descricao
	                                    )
	                                )
	                            )
	                        );
	                    })
	                )
	            );
	        }

	    });

	    var Musica = React.createClass({
	        displayName: "Musica",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get(this.props.source, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var linkToAnexos = '';

	            return React.createElement(
	                "div",
	                null,
	                React.createElement(
	                    Card,
	                    { sectionName: "Adicionadas Recentemente" },
	                    React.createElement(
	                        "figure",
	                        { className: "wow fadeInLeft animated portfolio-item" },
	                        this.state.data.map(function (musica) {

	                            linkToAnexos = "/user/praise/" + musica.id + "-" + musica.nome.toLowerCase().replace(/ /g, '_') + "/attachments";

	                            return React.createElement(
	                                "div",
	                                { key: musica.id, className: "col-sm-12 col-xs-12" },
	                                React.createElement(
	                                    "h4",
	                                    { className: "tile is-4" },
	                                    React.createElement(
	                                        "a",
	                                        { href: linkToAnexos },
	                                        musica.numero,
	                                        " ",
	                                        musica.nome
	                                    )
	                                )
	                            );
	                        })
	                    )
	                )
	            );
	        }

	    });

	    const Videos = React.createClass({
	        displayName: "Videos",


	        render: function () {

	            return React.createElement(
	                "div",
	                null,
	                React.createElement(
	                    CardBlue,
	                    { sectionName: "Videos" },
	                    React.createElement(
	                        "a",
	                        { href: "/user/musica/anexos/videos", className: "btn btn-default btn-contact wow fadeInDown", "data-wow-delay": ".7s", "data-wow-duration": "500ms" },
	                        "Acessar"
	                    )
	                )
	            );
	        }

	    });

	    const menu = $("#user").data("menu");
	    const dirMenu = $("#user").data("dir-menu");
	    const colecao = $("#user").data("colecao");
	    const dirColecao = $("#user").data("dir-colecao");
	    const defaultBackground = $("#user").data("default-background");
	    const musica = $("#user").data("musica");
	    const videos = $("#user").data("videos");
	    const user = $("#user").data("user");
	    const app = $("#user").data("app");

	    if (document.getElementById("user")) {
	        ReactDOM.render(React.createElement(
	            "div",
	            null,
	            React.createElement(CardHero, { defaultBackground: defaultBackground, user: user, app: app }),
	            React.createElement(Colecao, { source: colecao, dirColecao: dirColecao, defaultBackground: defaultBackground }),
	            React.createElement(Musica, { source: musica }),
	            React.createElement(Videos, { source: videos })
	        ), document.getElementById('user'));
	    }
	});

/***/ },
/* 5 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 20/10/16.
	 */

	$(function () {

	    const ROLE_ADMIN = 'ROLE_ADMIN';
	    const ROLE_USER = 'ROLE_USER';

	    var UploadArquivo = React.createClass({
	        displayName: 'UploadArquivo',


	        handleSubmit: function (e) {

	            e.preventDefault();

	            var _this = this;

	            var id = this.refs.id.value.trim();
	            var arquivo = this.refs.arquivo.value.trim();

	            if (!arquivo) {
	                alertify.error("Erro no arquivo.");
	                return false;
	            }

	            var fd = new FormData();
	            var files = this.refs.arquivo.files;

	            $.each(files, function (index, value) {
	                fd.append('files[]', files[index]);
	            });

	            $("#btn-upload").addClass("is-loading");
	            block_screen();

	            $.ajax({
	                type: "POST",
	                url: "/user/musica/" + id + "/anexos/upload",
	                enctype: "multipart/form-data",
	                data: fd,
	                processData: false,
	                contentType: false,
	                cache: false,
	                success: function (data) {
	                    alertify.success(data.message);
	                    _this.props.reloadArquivos();
	                    _this.props.closeModal();
	                    $("#btn-upload").removeClass("is-loading");
	                    unblock_screen();
	                },
	                error: function (data) {
	                    $("#btn-upload").removeClass("is-loading");
	                    alertify.error(data.message);
	                    unblock_screen();
	                }
	            });
	        },

	        render: function () {

	            var modal = null;
	            modal = React.createElement(
	                'div',
	                { id: 'modal-musicas', className: 'modal fade', tabIndex: '-1' },
	                React.createElement(
	                    'div',
	                    { className: 'modal-dialog' },
	                    React.createElement(
	                        'div',
	                        { className: 'modal-content' },
	                        React.createElement(
	                            'div',
	                            { className: 'modal-header' },
	                            React.createElement(
	                                'button',
	                                { type: 'button', className: 'close', 'data-dismiss': 'modal' },
	                                React.createElement(
	                                    'span',
	                                    null,
	                                    '\xD7'
	                                )
	                            ),
	                            React.createElement(
	                                'h4',
	                                { className: 'modal-title' },
	                                this.props.title
	                            )
	                        ),
	                        React.createElement(
	                            'form',
	                            { className: 'form-horizontal', ref: 'uploadForm', onSubmit: this.handleSubmit },
	                            React.createElement(
	                                'div',
	                                { className: 'modal-body' },
	                                React.createElement('input', { type: 'hidden', name: 'musica', ref: 'id', defaultValue: this.props.musica }),
	                                React.createElement('input', { className: 'input', type: 'file', ref: 'arquivo', name: 'files[]', id: 'filer_input',
	                                    multiple: true })
	                            ),
	                            React.createElement(
	                                'div',
	                                { className: 'modal-footer' },
	                                React.createElement(
	                                    'button',
	                                    { type: 'button', className: 'button is-danger is-pulled-left',
	                                        'data-dismiss': 'modal' },
	                                    'Cancelar'
	                                ),
	                                React.createElement(
	                                    'button',
	                                    { id: 'btn-upload', type: 'submit', className: 'button is-success' },
	                                    'Salvar'
	                                )
	                            )
	                        )
	                    )
	                )
	            );

	            return React.createElement(
	                'div',
	                null,
	                modal
	            );
	        }
	    });

	    var AddLink = React.createClass({
	        displayName: 'AddLink',


	        handleSubmit: function (e) {

	            e.preventDefault();

	            var _this = this;

	            var id = this.refs.musica.value.trim();
	            var tipo = this.refs.tipo.value.trim();
	            var link = this.refs.link.value.trim();

	            if (!link) {
	                alertify.error("Erro no arquivo.");
	                return false;
	            }

	            $("#btn-upload").addClass("is-loading");
	            block_screen();

	            $.ajax({
	                type: "POST",
	                url: "/user/musica/" + id + "/anexos/save",
	                data: {
	                    id: id,
	                    tipo: tipo,
	                    link: link
	                },
	                cache: false,
	                success: function (data) {
	                    alertify.success(data.message);
	                    _this.props.reloadArquivos();
	                    _this.props.closeModal();
	                    unblock_screen();
	                },
	                error: function (data) {
	                    unblock_screen();
	                    $("#btn-upload").removeClass("is-loading");
	                    alertify.error(data.message);
	                }
	            });
	        },

	        getInitialState: function () {
	            return { data: [] };
	        },
	        load: function () {
	            $.get('/user/tipos/anexos', function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },
	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var modal = null;
	            modal = React.createElement(
	                'div',
	                { id: 'modal-add-link', className: 'modal fade', tabIndex: '-1' },
	                React.createElement(
	                    'div',
	                    { className: 'modal-dialog' },
	                    React.createElement(
	                        'div',
	                        { className: 'modal-content' },
	                        React.createElement(
	                            'div',
	                            { className: 'modal-header' },
	                            React.createElement(
	                                'button',
	                                { type: 'button', className: 'close', 'data-dismiss': 'modal' },
	                                React.createElement(
	                                    'span',
	                                    null,
	                                    '\xD7'
	                                )
	                            ),
	                            React.createElement(
	                                'h4',
	                                { className: 'modal-title' },
	                                this.props.title
	                            )
	                        ),
	                        React.createElement(
	                            'form',
	                            { className: 'form-horizontal', onSubmit: this.handleSubmit },
	                            React.createElement(
	                                'div',
	                                { className: 'modal-body' },
	                                React.createElement('input', { type: 'hidden', name: 'musica', id: 'musica', ref: 'musica',
	                                    defaultValue: this.props.musica }),
	                                React.createElement(
	                                    'p',
	                                    { className: 'control' },
	                                    React.createElement(
	                                        'label',
	                                        null,
	                                        'Tipo Arquivo'
	                                    ),
	                                    React.createElement(
	                                        'select',
	                                        { name: 'tipo', id: 'tipo', ref: 'tipo', className: 'input' },
	                                        this.state.data.map(function (tipo) {
	                                            return React.createElement(
	                                                'option',
	                                                { key: tipo.id, value: tipo.id },
	                                                tipo.nome
	                                            );
	                                        })
	                                    )
	                                ),
	                                React.createElement(
	                                    'p',
	                                    { className: 'control' },
	                                    React.createElement(
	                                        'label',
	                                        null,
	                                        'Link'
	                                    ),
	                                    React.createElement('input', { className: 'input', type: 'text', placeholder: 'Link', name: 'link', id: 'link',
	                                        ref: 'link',
	                                        required: true })
	                                )
	                            ),
	                            React.createElement(
	                                'div',
	                                { className: 'modal-footer' },
	                                React.createElement(
	                                    'button',
	                                    { type: 'button', className: 'button is-danger is-outlined is-pulled-left',
	                                        'data-dismiss': 'modal' },
	                                    'Cancelar'
	                                ),
	                                React.createElement(
	                                    'button',
	                                    { type: 'submit', className: 'button is-success' },
	                                    'Salvar'
	                                )
	                            )
	                        )
	                    )
	                )
	            );

	            return React.createElement(
	                'div',
	                null,
	                modal
	            );
	        }
	    });

	    var styleCard = { width: '100%', minWidth: '150px' };
	    var styleImg = {
	        minWidth: '64px', maxWidth: '64px', minHeight: '64px', maxHeight: '64px', margin: 'auto'
	    };
	    var styleCardLetra = {
	        backgroundColor: 'transparent', border: 'none'
	    };

	    var RemoverComentario = React.createClass({
	        displayName: 'RemoverComentario',


	        handleRemoverComentario: function (e) {

	            e.preventDefault();

	            const _this = this;

	            alertify.confirm("Deseja remover este Coment&aacute;rio?", function () {

	                block_screen();

	                $.ajax({
	                    type: 'POST',
	                    url: '/user/musica/anexos/comentario/' + _this.props.comentario.id + '/remover',
	                    cache: false,
	                    success: function (data) {
	                        alertify.success(data.message);
	                        unblock_screen();
	                        _this.props.reloadComentarios();
	                    },
	                    error: function () {
	                        unblock_screen();
	                        alertify.error("Ocorreu um erro.");
	                    }
	                });
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },

	        render: function () {

	            return React.createElement(
	                'button',
	                { className: 'button is-light is-small', onClick: this.handleRemoverComentario,
	                    'data-comentario': this.props.comentario },
	                'Remover'
	            );
	        }
	    });

	    var CardComentarios = React.createClass({
	        displayName: 'CardComentarios',


	        render: function () {
	            return React.createElement(
	                'div',
	                { className: 'card wow fadeInUp animated slide', 'data-wow-delay': '.3s', style: styleCard },
	                React.createElement(
	                    'div',
	                    { className: 'card-content' },
	                    React.createElement(
	                        'p',
	                        { className: 'title is-5' },
	                        'Coment\xE1rios'
	                    ),
	                    React.createElement(
	                        'div',
	                        { className: 'comments' },
	                        this.props.children
	                    )
	                )
	            );
	        }

	    });

	    const ListComentarios = React.createClass({
	        displayName: 'ListComentarios',


	        componentDidMount: function () {
	            return setInterval(this.props.reloadComentarios, 10000);
	        },

	        render: function () {

	            const _this = this;

	            return React.createElement(
	                'div',
	                null,
	                _this.props.data.map(function (comentario) {

	                    let img = _this.props.dirAvatar + comentario.usuario.avatar;

	                    let removerComentario = '';

	                    if (_this.props.user == ROLE_ADMIN || comentario.usuario.id == _this.props.userId) {
	                        removerComentario = React.createElement(RemoverComentario, { comentario: comentario,
	                            reloadComentarios: _this.props.reloadComentarios });
	                    }

	                    return React.createElement(
	                        'div',
	                        { key: comentario.id, className: 'media' },
	                        React.createElement(ImageComentario, { avatar: img }),
	                        React.createElement(
	                            'div',
	                            { className: 'media-body' },
	                            React.createElement(
	                                'h4',
	                                { className: 'media-heading' },
	                                comentario.usuario.nome,
	                                '\xA0',
	                                React.createElement(
	                                    'a',
	                                    { className: 'button is-white is-small' },
	                                    comentario.cadastro
	                                )
	                            ),
	                            React.createElement(
	                                'p',
	                                { className: 'text-muted' },
	                                comentario.comentario
	                            )
	                        ),
	                        removerComentario
	                    );
	                })
	            );
	        }
	    });

	    var ImageComentario = React.createClass({
	        displayName: 'ImageComentario',


	        render: function () {
	            return React.createElement(
	                'a',
	                { className: 'pull-left' },
	                React.createElement('img', { style: styleImg,
	                    alt: 'user',
	                    src: this.props.avatar,
	                    className: 'media-object  img img-circle' })
	            );
	        }
	    });

	    var FormComentario = React.createClass({
	        displayName: 'FormComentario',


	        handleSubmit: function (e) {

	            e.preventDefault();

	            var id = this.refs.id.value.trim();
	            var comentario = this.refs.comentario.value.trim();

	            var _this = this;

	            if ('' == comentario) {
	                $("#comentario").addClass("is-danger");
	                alertify.error('Deve informar um comentario');
	                _this.refs.comentario.focus();
	                return false;
	            }

	            $("#comentario").removeClass("is-danger");
	            $("#comentar").addClass("is-loading");

	            $.ajax({
	                type: "POST",
	                url: "/user/musica/" + id + "/anexos/comentar",
	                data: {
	                    "id": id,
	                    "comentario": comentario
	                },
	                cache: false,
	                success: function (data) {
	                    $("#comentar").removeClass("is-loading");
	                    unblock_screen();
	                    $(".emojionearea-editor").text("");
	                    _this.refs.comentario.value = '';
	                    _this.props.reloadComentarios();
	                },
	                error: function () {
	                    $("#comentar").removeClass("is-loading");
	                    unblock_screen();
	                    alertify.error("Ocorreu um erro.");
	                }
	            });
	        },

	        render: function () {

	            return React.createElement(
	                'div',
	                { className: 'post-comment' },
	                React.createElement(
	                    'form',
	                    { className: 'form-horizontal' },
	                    React.createElement('input', { type: 'hidden', name: 'musica_id', id: 'musica_id', ref: 'id',
	                        defaultValue: this.props.musicaId }),
	                    React.createElement(
	                        'div',
	                        { className: 'form-group' },
	                        React.createElement(
	                            'div',
	                            { className: 'col-lg-12' },
	                            React.createElement('textarea', { className: 'textarea', name: 'comentario', id: 'comentario', ref: 'comentario', placeholder: '...' })
	                        )
	                    ),
	                    React.createElement(
	                        'p',
	                        null,
	                        React.createElement(
	                            'button',
	                            { id: 'comentar', ref: 'submit', className: 'button is-light is-fullwidth is-success', onClick: this.handleSubmit },
	                            'Enviar'
	                        )
	                    )
	                )
	            );
	        }
	    });

	    var ViewCometarios = React.createClass({
	        displayName: 'ViewCometarios',


	        getInitialState: function () {
	            return { data: [] };
	        },
	        load: function () {
	            var _this = this;
	            $.get(_this.props.source, function (result) {
	                _this.setState({ data: result });
	            }.bind(_this));
	        },
	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {
	            return React.createElement(
	                'div',
	                null,
	                React.createElement(
	                    CardComentarios,
	                    null,
	                    React.createElement(ListComentarios, { user: this.props.user, userId: this.props.userId, data: this.state.data,
	                        dirAvatar: this.props.dirAvatar,
	                        reloadComentarios: this.load }),
	                    React.createElement('br', null),
	                    React.createElement(FormComentario, { musicaId: this.props.musicaId, reloadComentarios: this.load })
	                )
	            );
	        }
	    });

	    class BtnRemover extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { className: 'button is-danger is-inverted is-small', onClick: this.props.acao },
	                'Remover'
	            );
	        }

	    }

	    class BtnDownload extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.anexo, download: 'download', className: 'button is-white is-small' },
	                'Baixar'
	            );
	        }

	    }

	    class BtnVisualizar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.anexo, target: '_Blank', className: 'button is-light is-small' },
	                'Visualizar'
	            );
	        }
	    }

	    class BtnEditar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.source, className: 'button is-light is-small is-pulled-right' },
	                'Editar Letra'
	            );
	        }
	    }

	    class BtnView extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.sourceView, className: 'button is-light is-small is-pulled-right' },
	                'Tela Cheia'
	            );
	        }
	    }

	    class BtnEditarMusica extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.source, className: 'button is-light is-small' },
	                'Editar M\xFAsica'
	            );
	        }
	    }

	    class BtnAdicionarArquivo extends React.Component {

	        render() {
	            return React.createElement(
	                'button',
	                { onClick: this.props.openModal, className: 'button is-light is-small' },
	                'Adicionar Arquivo'
	            );
	        }
	    }

	    class BtnAddLetra extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.source, className: 'button is-light is-small' },
	                'Adicionar Letra'
	            );
	        }
	    }

	    class BtnAddLink extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { onClick: this.props.openModal, className: 'button is-light is-small' },
	                'Adicionar Link'
	            );
	        }
	    }

	    class BtnLink extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.href, target: '_Blank', className: 'button is-white is-small' },
	                'Ir para o Link'
	            );
	        }
	    }

	    class BtnFavoritos extends React.Component {

	        render() {

	            let btn = '';

	            if (this.props.isFavorito === true) {
	                btn = React.createElement(
	                    'a',
	                    { className: 'button is-small is-danger is-inverted add-remove', onClick: this.props.handle },
	                    'Remover dos Favoritos'
	                );
	            } else {
	                btn = React.createElement(
	                    'a',
	                    { className: 'button is-small is-light add-remove', onClick: this.props.handle },
	                    'Adicionar aos Favoritos'
	                );
	            }

	            return React.createElement(
	                'span',
	                null,
	                btn
	            );
	        }
	    }

	    class CardLetra extends React.Component {

	        render() {
	            return React.createElement(
	                'div',
	                null,
	                React.createElement(
	                    'div',
	                    { className: 'card wow fadeInUp animated slide', 'data-wow-delay': '.3s', style: styleCard },
	                    React.createElement(
	                        'div',
	                        { className: 'card-content' },
	                        React.createElement(
	                            'p',
	                            { className: 'title is-5' },
	                            this.props.label
	                        ),
	                        React.createElement(
	                            'div',
	                            { className: 'media' },
	                            React.createElement(
	                                'div',
	                                { className: 'media-content' },
	                                this.props.children
	                            )
	                        )
	                    )
	                ),
	                React.createElement('br', null)
	            );
	        }
	    }
	    ;

	    class BlockLetra extends React.Component {

	        render() {
	            return React.createElement(
	                'pre',
	                { id: 'content', style: styleCardLetra,
	                    'data-key': this.props.sourceMusicaTom },
	                this.props.sourceMusicaLetra
	            );
	        }

	    }

	    class Font extends React.Component {

	        render() {
	            return React.createElement(
	                'div',
	                { className: 'control is-grouped', id: 'fontlinks' },
	                React.createElement(
	                    'p',
	                    { className: 'control has-addon' },
	                    React.createElement(
	                        'button',
	                        { id: 'incfont', className: 'button is-light is-small buttonfont' },
	                        'A+'
	                    )
	                ),
	                React.createElement(
	                    'p',
	                    { className: 'control' },
	                    React.createElement(
	                        'button',
	                        { id: 'decfont', className: 'button is-light is-small buttonfont' },
	                        'A-'
	                    )
	                ),
	                React.createElement(
	                    'p',
	                    { className: 'control' },
	                    React.createElement(BtnView, { sourceView: this.props.sourceView })
	                ),
	                React.createElement(
	                    'p',
	                    { className: 'control' },
	                    React.createElement(BtnEditar, { source: this.props.source })
	                )
	            );
	        }
	    }

	    var RemoverArquivo = React.createClass({
	        displayName: 'RemoverArquivo',


	        handleRemover: function (e) {

	            e.preventDefault();

	            var id = this.props.anexo.id;
	            var _this = this;

	            alertify.confirm("Deseja remover este arquivo?", function () {

	                block_screen();

	                $.ajax({
	                    type: "POST",
	                    url: "/user/musica/anexos/" + id + "/remover",
	                    cache: false,
	                    success: function (data) {
	                        unblock_screen();
	                        alertify.success(data.message);
	                        _this.props.reloadArquivos();
	                    },
	                    error: function () {
	                        unblock_screen();
	                        alertify.error("Ocorreu um erro.");
	                    }
	                });
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },

	        render: function () {
	            return React.createElement(BtnRemover, { acao: this.handleRemover });
	        }

	    });

	    var ImagemArquivo = React.createClass({
	        displayName: 'ImagemArquivo',


	        render: function () {

	            if (!this.props.anexo.tipo) {
	                alertify.error("Nenhum tipo foi cadastrado para o arquivo.");
	                return false;
	            }

	            let icone = 'fa fa-music';

	            if (this.props.anexo.tipo.icone.length > 0) {
	                icone = this.props.anexo.tipo.icone;
	            }

	            let image = React.createElement(
	                'i',
	                { className: icone },
	                '\xA0'
	            );

	            return React.createElement(
	                'div',
	                { className: 'media-left media-middle' },
	                image
	            );
	        }

	    });

	    const ListArquivos = React.createClass({
	        displayName: 'ListArquivos',


	        componentDidMount: function () {
	            return setInterval(this.props.reloadArquivos, 10000);
	        },

	        render: function () {

	            const _this = this;

	            return React.createElement(
	                'div',
	                null,
	                this.props.anexos.map(function (anexo) {

	                    let arquivo = _this.props.dirAnexos + anexo.nome;

	                    let visualzar = '';
	                    let downLoad = '';
	                    let link = '';
	                    let btn = '';

	                    if (!anexo.isExterno) {
	                        visualzar = React.createElement(BtnVisualizar, { anexo: arquivo });
	                        downLoad = React.createElement(BtnDownload, { anexo: arquivo });
	                    } else {
	                        link = React.createElement(BtnLink, { href: _this.props.sourceVideos });
	                    }

	                    if (ROLE_ADMIN == _this.props.user || _this.props.userId == anexo.usuario) {
	                        btn = React.createElement(RemoverArquivo, { anexo: anexo, reloadArquivos: _this.props.reloadArquivos });
	                    }

	                    return React.createElement(
	                        'div',
	                        { key: anexo.id },
	                        React.createElement(
	                            'div',
	                            { className: 'media' },
	                            React.createElement(ImagemArquivo, { anexo: anexo }),
	                            React.createElement(
	                                'div',
	                                { className: 'media-body' },
	                                React.createElement(
	                                    'h4',
	                                    { className: 'media-heading' },
	                                    anexo.nome,
	                                    React.createElement(
	                                        'a',
	                                        { className: 'button is-light is-small is-pulled-right' },
	                                        anexo.cadastro
	                                    )
	                                ),
	                                visualzar,
	                                downLoad,
	                                link,
	                                btn
	                            )
	                        ),
	                        React.createElement('br', null)
	                    );
	                })
	            );
	        }

	    });

	    const ViewOpcoes = React.createClass({
	        displayName: 'ViewOpcoes',


	        getInitialState: function () {
	            return { data: [], favorito: false };
	        },
	        load: function () {
	            $.get(this.props.sourceArquivos, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        loadFavoritos: function () {
	            $.get('/api/favorites/praise/' + this.props.musica, function (result) {
	                this.setState({ favorito: result.length > 0 });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	            this.loadFavoritos();
	        },

	        openModal: function () {
	            $("#modal-musicas").modal("show");
	        },
	        closeModal: function () {
	            $("#modal-musicas").modal("hide");
	        },
	        openModalAddLink: function () {
	            $("#modal-add-link").modal("show");
	        },
	        closeModalAddLink: function () {
	            $("#modal-add-link").modal("hide");
	        },

	        handleFavoritos: function () {

	            const _this = this;
	            let id = this.props.musica;
	            $("#add-remove").addClass("is-loading");

	            block_screen(500);

	            $.ajax({
	                type: "POST",
	                url: "/api/favoritos/add-remove",
	                data: {
	                    "id": id
	                },
	                cache: false,
	                success: function (data) {
	                    $("#add-remove").removeClass("is-loading");
	                    unblock_screen();
	                    alertify.success(data.mensagem);
	                    _this.loadFavoritos();
	                },
	                error: function () {
	                    $("#add-remove").removeClass("is-loading");
	                    unblock_screen();
	                    alertify.error("Ocorreu um erro.");
	                }
	            });
	        },

	        render: function () {

	            let menu = '';
	            let card = '';
	            let letra = '';
	            let cardArquivos = '';

	            if (!this.props.dataMusica.letra) {
	                letra = React.createElement(
	                    'p',
	                    { className: 'control' },
	                    React.createElement(BtnAddLetra, { source: this.props.sourceAddLetra })
	                );
	            }

	            if (this.props.user == ROLE_ADMIN) {
	                menu = React.createElement(
	                    'div',
	                    { className: 'control is-grouped' },
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnFavoritos, { handle: this.handleFavoritos, isFavorito: this.state.favorito, dataMusica: this.props.dataMusica })
	                    ),
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnEditarMusica, { source: this.props.sourceEditar })
	                    ),
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnAddLink, { openModal: this.openModalAddLink })
	                    ),
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnAdicionarArquivo, { openModal: this.openModal })
	                    ),
	                    letra
	                );
	            } else {
	                menu = React.createElement(
	                    'div',
	                    { className: 'control is-grouped' },
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnFavoritos, { handle: this.handleFavoritos, isFavorito: this.state.favorito, dataMusica: this.props.dataMusica })
	                    )
	                );
	            }

	            if (this.props.user == ROLE_ADMIN) {

	                card = React.createElement(
	                    'div',
	                    null,
	                    React.createElement(UploadArquivo, { reloadArquivos: this.load, openModal: this.openModal,
	                        closeModal: this.closeModal,
	                        musica: this.props.musica }),
	                    React.createElement(AddLink, { reloadArquivos: this.load, openModal: this.openModalAddLink,
	                        closeModal: this.closeModalAddLink, musica: this.props.musica })
	                );
	            }

	            if (this.state.data.length > 0) {
	                cardArquivos = React.createElement(
	                    CardLetra,
	                    { label: 'Arquivos' },
	                    React.createElement(ListArquivos, { reloadArquivos: this.load,
	                        anexos: this.state.data,
	                        sourceArquivos: this.props.sourceArquivos,
	                        sourceVideos: this.props.sourceVideos,
	                        user: this.props.user,
	                        userId: this.props.userId,
	                        dirAnexos: this.props.dirAnexos })
	                );
	            }

	            return React.createElement(
	                'div',
	                null,
	                React.createElement(
	                    CardLetra,
	                    { label: 'Menu' },
	                    menu
	                ),
	                card,
	                cardArquivos
	            );
	        }
	    });

	    const ViewLetra = React.createClass({
	        displayName: 'ViewLetra',


	        render: function () {

	            let card = '';

	            if (this.props.sourceMusicaLetra) {
	                card = React.createElement(
	                    CardLetra,
	                    { label: 'Letra' },
	                    React.createElement(Font, {
	                        source: this.props.sourceAddLetra,
	                        sourceView: this.props.sourceView }),
	                    React.createElement(BlockLetra, {
	                        musica: this.props.dataMusica,
	                        sourceMusicaLetra: this.props.sourceMusicaLetra,
	                        sourceMusicaTom: this.props.sourceMusicaTom })
	                );
	            }

	            return React.createElement(
	                'div',
	                null,
	                card
	            );
	        }
	    });

	    const Render = React.createClass({
	        displayName: 'Render',


	        getInitialState: function () {
	            return { data: [] };
	        },
	        load: function () {
	            $.get(this.props.sourceMusica, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },
	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {
	            return React.createElement(
	                Base,
	                null,
	                React.createElement(ViewOpcoes, {
	                    dataMusica: this.state.data,
	                    sourceArquivos: this.props.sourceArquivos,
	                    sourceEditar: this.props.sourceEditar,
	                    sourceMusicaLetra: this.props.sourceMusicaLetra,
	                    sourceAddLetra: this.props.sourceAddLetra,
	                    sourceVideos: this.props.sourceVideos,
	                    musica: this.props.musicaId,
	                    dirAnexos: this.props.dirAnexos,
	                    user: this.props.user,
	                    userId: this.props.userId }),
	                React.createElement(ViewLetra, {
	                    dataMusica: this.state.data,
	                    sourceView: this.props.sourceView,
	                    sourceMusicaLetra: this.props.sourceMusicaLetra,
	                    sourceMusicaTom: this.props.sourceMusicaTom,
	                    sourceAddLetra: this.props.sourceAddLetra }),
	                React.createElement(ViewCometarios, {
	                    source: this.props.source,
	                    user: this.props.user,
	                    userId: this.props.userId,
	                    dirAvatar: this.props.dirAvatar,
	                    musicaId: this.props.musicaId })
	            );
	        }
	    });

	    class Base extends React.Component {
	        render() {
	            return React.createElement(
	                'article',
	                null,
	                React.createElement(
	                    'div',
	                    { className: 'container' },
	                    React.createElement(
	                        'div',
	                        { className: 'row' },
	                        React.createElement(
	                            'div',
	                            { className: 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' },
	                            this.props.children
	                        )
	                    )
	                )
	            );
	        }
	    }

	    const source = $("#comentarios").attr("data-source");
	    const sourceView = $("#comentarios").data("source-view");
	    const sourceArquivos = $("#comentarios").attr("data-source-arquivos");
	    const sourceVideos = $("#comentarios").attr("data-source-videos");
	    const sourceEditar = $("#comentarios").attr("data-source-editar");
	    const sourceAddLetra = $("#comentarios").attr("data-source-add-letra");
	    const sourceMusica = $("#comentarios").attr("data-source-musica");
	    const sourceMusicaLetra = $("#comentarios").attr("data-source-musica-letra");
	    const sourceMusicaTom = $("#comentarios").attr("data-source-musica-tom");

	    const musicaId = $("#comentarios").attr("data-musica-id");
	    const user = $("#comentarios").attr("data-user");
	    const userId = $("#comentarios").data("user-id");
	    const dirAvatar = $("#comentarios").attr("data-dir-avatar");
	    const dirAnexos = $("#comentarios").attr("data-dir-anexos");

	    if (document.getElementById('comentarios')) {

	        ReactDOM.render(React.createElement(Render, { sourceMusica: sourceMusica,
	            sourceAddLetra: sourceAddLetra,
	            sourceView: sourceView,
	            sourceArquivos: sourceArquivos,
	            sourceEditar: sourceEditar,
	            sourceVideos: sourceVideos,
	            musica: musicaId,
	            dirAnexos: dirAnexos,
	            source: source,
	            user: user,
	            userId: userId,
	            dirAvatar: dirAvatar,
	            musicaId: musicaId,
	            sourceMusicaLetra: sourceMusicaLetra,
	            sourceMusicaTom: sourceMusicaTom
	        }), document.getElementById('comentarios'));

	        $("#comentario").emojioneArea({
	            autoHideFilters: true,
	            autocomplete: true,
	            useSprite: true
	        });

	        $('#incfont').click(function () {
	            curSize = parseInt($('#content').css('font-size')) + 2;
	            curSize2 = parseInt($('.c').css('font-size')) + 2;
	            if (curSize <= 32) $('#content').css('font-size', curSize);
	            if (curSize2 <= 32) $('.c').css('font-size', curSize2);
	        });
	        $('#decfont').click(function () {
	            curSize = parseInt($('#content').css('font-size')) - 2;
	            curSize2 = parseInt($('.c').css('font-size')) - 2;
	            if (curSize >= 5) $('#content').css('font-size', curSize);
	            if (curSize2 >= 5) $('.c').css('font-size', curSize2);
	        });

	        $("pre").transpose({ key: 'C' });
	        $('.c').css('font-size', 12);
	        $('#content').css('font-size', 12);
	    }
	});

/***/ },
/* 6 */
/***/ function(module, exports) {

	
	const styleCard = { width: '100%', minWidth: '150px' };
	const styleCardLetra = { backgroundColor: 'transparent', border: 'none' };

	const VIEW = React.createClass({
	    displayName: 'VIEW',


	    getInitialState: function () {
	        return {
	            data: []
	        };
	    },

	    load: function () {

	        $.get(this.props.source, function (result) {
	            this.setState({ data: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    render: function () {
	        return React.createElement(
	            Base,
	            null,
	            React.createElement(
	                Card,
	                null,
	                React.createElement(
	                    'h2',
	                    null,
	                    this.state.data.nome
	                ),
	                React.createElement(FontControl, null),
	                React.createElement(
	                    'pre',
	                    { id: 'content-view', style: styleCardLetra, 'data-key': this.state.data.tom },
	                    this.state.data.letra
	                )
	            )
	        );
	    }

	});

	class FontControl extends React.Component {

	    render() {
	        return React.createElement(
	            'div',
	            { className: 'control is-grouped', id: 'fontlinks' },
	            React.createElement(
	                'p',
	                { className: 'control has-addon' },
	                React.createElement(
	                    'button',
	                    { id: 'incfont', className: 'button is-light is-small buttonfont' },
	                    'A+'
	                )
	            ),
	            React.createElement(
	                'p',
	                { className: 'control' },
	                React.createElement(
	                    'button',
	                    { id: 'decfont', className: 'button is-light is-small buttonfont' },
	                    'A-'
	                )
	            )
	        );
	    }
	}

	class Card extends React.Component {

	    render() {
	        return React.createElement(
	            'div',
	            null,
	            React.createElement(
	                'div',
	                { className: 'card wow fadeInUp animated slide', 'data-wow-delay': '.3s', style: styleCard },
	                React.createElement(
	                    'div',
	                    { className: 'card-content' },
	                    React.createElement(
	                        'div',
	                        { className: 'media' },
	                        React.createElement(
	                            'div',
	                            { className: 'media-content' },
	                            this.props.children
	                        )
	                    )
	                )
	            ),
	            React.createElement('br', null)
	        );
	    }
	}
	;

	class Base extends React.Component {
	    render() {
	        return React.createElement(
	            'article',
	            null,
	            React.createElement(
	                'div',
	                { className: 'container' },
	                React.createElement(
	                    'div',
	                    { className: 'row' },
	                    React.createElement(
	                        'div',
	                        { className: 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }
	}

	if (document.getElementById("view")) {

	    const MUSICA_SOURCE = $("#view").data("praise");

	    ReactDOM.render(React.createElement(VIEW, { source: MUSICA_SOURCE }), document.getElementById("view"));

	    $('#incfont').click(function () {
	        curSize = parseInt($('#content-view').css('font-size')) + 2;
	        curSize2 = parseInt($('.c').css('font-size')) + 2;
	        if (curSize <= 32) $('#content').css('font-size', curSize);
	        if (curSize2 <= 32) $('.c').css('font-size', curSize2);
	    });
	    $('#decfont').click(function () {
	        curSize = parseInt($('#content-view').css('font-size')) - 2;
	        curSize2 = parseInt($('.c').css('font-size')) - 2;
	        if (curSize >= 5) $('#content').css('font-size', curSize);
	        if (curSize2 >= 5) $('.c').css('font-size', curSize2);
	    });

	    $('.c').css('font-size', 12);
	    $('#content-view').css('font-size', 12);
	    $("#content-view").transpose({ key: 'C' });
	}

/***/ },
/* 7 */
/***/ function(module, exports) {

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

	            return React.createElement(
	                'a',
	                { href: url, className: 'button is-light is-small' },
	                'Editar'
	            );
	        }

	    };

	    class BtnInativar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { className: 'button is-light is-small mudarStatus', onClick: this.props.acao, 'data-categoria': this.props.categoria.id },
	                'Inativar'
	            );
	        }

	    };

	    class BtnAtivar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { className: 'button is-light is-small mudarStatus', onClick: this.props.acao, 'data-categoria': this.props.categoria.id },
	                'Ativar'
	            );
	        }

	    };

	    class BtnAddCategoria extends React.Component {
	        render() {

	            const url = "/user/category/new?collection_id=" + this.props.colecao + "collection_name=" + this.props.colecaoNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                'a',
	                { href: url, className: 'button is-light is-small' },
	                'Nova Categoria'
	            );
	        }
	    };

	    const BlockCategorias = React.createClass({
	        displayName: 'BlockCategorias',


	        render: function () {

	            let btns = '';

	            if (this.props.user == ROLE_ADMIN) {
	                btns = React.createElement(
	                    'div',
	                    { className: 'control is-grouped is-centered' },
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(MudarStatusCategoria, { categoria: this.props.categoria, reloadCategoria: this.props.reloadCategoria })
	                    ),
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(BtnEditar, { categoria: this.props.categoria, acao: this.props.acao })
	                    ),
	                    React.createElement(
	                        'p',
	                        { className: 'control' },
	                        React.createElement(
	                            'span',
	                            {
	                                className: 'tag is-light is-pulled-right' },
	                            this.props.categoria.qtde_musicas
	                        )
	                    )
	                );
	            }

	            return React.createElement(
	                'div',
	                { className: 'col-sm-6 col-xs-12' },
	                React.createElement(
	                    'figure',
	                    { className: 'wow fadeInLeft animated portfolio-item' },
	                    React.createElement(
	                        'figcaption',
	                        null,
	                        React.createElement(
	                            'h2',
	                            { className: 'tile' },
	                            React.createElement(
	                                'a',
	                                { href: this.props.musicasUrl },
	                                this.props.categoria.nome
	                            )
	                        ),
	                        btns
	                    )
	                )
	            );
	        }
	    });

	    const MudarStatusCategoria = React.createClass({
	        displayName: 'MudarStatusCategoria',


	        loadStatus: function () {
	            this.props.reloadCategoria();
	            this.setState({ ativo: !this.props.categoria.ativo });
	        },

	        getInitialState: function () {
	            return { ativo: this.props.categoria.ativo };
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
	                });
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },
	        render: function () {

	            var btnStatus = '';

	            if (this.state.ativo) {
	                btnStatus = React.createElement(BtnInativar, { acao: this.handleInativarCategoria, categoria: this.props.categoria });
	            } else {
	                btnStatus = React.createElement(BtnAtivar, { acao: this.handleInativarCategoria, categoria: this.props.categoria });
	            }

	            return React.createElement(
	                'e',
	                null,
	                btnStatus
	            );
	        }

	    });

	    const CategoriasList = React.createClass({
	        displayName: 'CategoriasList',


	        render: function () {

	            const _this = this;

	            return React.createElement(
	                'div',
	                null,
	                React.createElement(
	                    'span',
	                    null,
	                    _this.props.categoria.map(function (categoria) {
	                        const musicasUrl = "/user/category/" + categoria.id + "-" + categoria.nome.toLowerCase().replace(/ /g, '_') + "/praises";
	                        return React.createElement(
	                            'div',
	                            { key: categoria.id },
	                            React.createElement(BlockCategorias, {
	                                categoria: categoria,
	                                musicasUrl: musicasUrl,
	                                user: _this.props.user,
	                                reloadCategoria: _this.props.reloadCategoria,
	                                acao: _this.openModal })
	                        );
	                    })
	                )
	            );
	        }
	    });

	    const OpcoesList = React.createClass({
	        displayName: 'OpcoesList',


	        render: function () {
	            return React.createElement(
	                'div',
	                null,
	                React.createElement(BtnAddCategoria, {
	                    colecao: this.props.colecao,
	                    colecaoNome: this.props.colecaoNome
	                }),
	                React.createElement('hr', { className: 'small' })
	            );
	        }

	    });

	    const View = React.createClass({
	        displayName: 'View',


	        getInitialState: function () {
	            return { data: [] };
	        },
	        load: function () {
	            const _this = this;
	            $.get(_this.props.source, function (result) {
	                _this.setState({ data: result });
	            }.bind(_this));
	        },
	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var opcoes = '';

	            if (this.props.user == ROLE_ADMIN) {
	                opcoes = React.createElement(OpcoesList, {
	                    reloadCategoria: this.load,
	                    colecao: this.props.colecao,
	                    colecaoNome: this.props.colecaoNome
	                });
	            }

	            return React.createElement(
	                Base,
	                null,
	                opcoes,
	                React.createElement(CategoriasList, { categoria: this.state.data, source: this.props.source, user: this.props.user, reloadCategoria: this.load, acao: this.openModal })
	            );
	        }
	    });

	    class Base extends React.Component {
	        render() {
	            return React.createElement(
	                'article',
	                null,
	                React.createElement(
	                    'div',
	                    { className: 'container' },
	                    React.createElement(
	                        'div',
	                        { className: 'row' },
	                        React.createElement(
	                            'div',
	                            { className: 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' },
	                            this.props.children
	                        )
	                    )
	                )
	            );
	        }
	    }

	    const source = $("#categorias").attr("data-source");
	    const user = $("#categorias").attr("data-user");

	    const colecao = $("#categorias").data("colecao");
	    const colecaoNome = $("#categorias").data("colecao-nome");

	    if (document.getElementById("categorias")) {
	        ReactDOM.render(React.createElement(
	            'div',
	            null,
	            React.createElement(View, {
	                source: source,
	                user: user,
	                colecao: colecao,
	                colecaoNome: colecaoNome
	            })
	        ), document.getElementById('categorias'));
	    }
	});

/***/ },
/* 8 */
/***/ function(module, exports) {

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
	            return React.createElement(
	                'a',
	                { className: 'button is-primary is-small openMenu',
	                    'data-toggle': 'modal',
	                    'data-target': '#myModal',
	                    'data-id': this.props.colecao.id,
	                    'data-nome': this.props.colecao.nome,
	                    'data-descricao': this.props.colecao.nome },
	                'Editar'
	            );
	        }

	    };

	    class BtnInativar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { className: 'button is-danger is-fullwidth is-small mudarStatus', onClick: this.props.acao, 'data-colecao': this.props.colecao.id },
	                'Inativar'
	            );
	        }

	    };

	    class BtnAtivar extends React.Component {

	        render() {
	            return React.createElement(
	                'a',
	                { className: 'button is-success is-fullwidth is-small mudarStatus', onClick: this.props.acao, 'data-colecao': this.props.colecao.id },
	                'Ativar'
	            );
	        }

	    };

	    class Image extends React.Component {
	        render() {
	            return React.createElement(
	                'a',
	                { href: this.props.categoriasUrl },
	                React.createElement('img', { className: 'img-responsive', style: divStyle, src: this.props.colecao.imagem ? this.props.dirImg + '' + this.props.colecao.imagem : this.props.defaultImage, alt: this.props.colecao.name })
	            );
	        }
	    };

	    class Figure extends React.Component {

	        render() {

	            var mudarStatus = '';
	            var editar = '';
	            let menu = '';

	            if (this.props.user == 'ROLE_ADMIN') {

	                mudarStatus = React.createElement(MudarStatusColecao, { colecao: this.props.colecao, reloadColecao: this.props.reloadColecao });
	                editar = React.createElement(BtnEditar, { colecao: this.props.colecao });

	                menu = React.createElement(
	                    'div',
	                    { className: 'btn-group' },
	                    React.createElement(
	                        'button',
	                        { type: 'button', className: 'button is-light is-small is-pulled-left dropdown-toggle ', 'data-toggle': 'dropdown', 'aria-haspopup': 'true', 'aria-expanded': 'false' },
	                        React.createElement('span', { className: 'caret' })
	                    ),
	                    React.createElement(
	                        'ul',
	                        { className: 'dropdown-menu' },
	                        React.createElement(
	                            'li',
	                            null,
	                            editar,
	                            mudarStatus
	                        )
	                    )
	                );
	            }

	            return React.createElement(
	                'figure',
	                { className: 'wow fadeInLeft animated portfolio-item' },
	                React.createElement(
	                    'div',
	                    { className: 'img-wrapper' },
	                    React.createElement(Image, { colecao: this.props.colecao, dirImg: this.props.dirImg, categoriasUrl: this.props.categoriasUrl, defaultImage: this.props.defaultImage })
	                ),
	                React.createElement(
	                    'figcaption',
	                    null,
	                    React.createElement(
	                        'h4',
	                        null,
	                        menu,
	                        React.createElement(
	                            'a',
	                            { href: this.props.categoriasUrl },
	                            this.props.colecao.nome,
	                            React.createElement(
	                                'span',
	                                { className: 'tag is-light' },
	                                this.props.colecao.qtde_categorias
	                            )
	                        )
	                    )
	                )
	            );
	        }
	    };

	    class BlockColecoes extends React.Component {

	        render() {

	            return React.createElement(
	                'div',
	                { className: 'col-sm-4 col-xs-12' },
	                React.createElement(Figure, { colecao: this.props.colecao, dirImg: this.props.dirImg, categoriasUrl: this.props.categoriasUrl,
	                    defaultImage: this.props.defaultImage, reloadColecao: this.props.reloadColecao, user: this.props.user })
	            );
	        }
	    };

	    var MudarStatusColecao = React.createClass({
	        displayName: 'MudarStatusColecao',


	        loadStatus: function () {
	            this.props.reloadColecao();
	            this.setState({ ativo: !this.props.colecao.ativo });
	        },

	        getInitialState: function () {
	            return { ativo: this.props.colecao.ativo };
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
	                });
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },
	        render: function () {

	            var btnStatus = '';

	            if (this.state.ativo) {
	                btnStatus = React.createElement(BtnInativar, { acao: this.handleInativarColecao, colecao: this.props.colecao });
	            } else {
	                btnStatus = React.createElement(BtnAtivar, { acao: this.handleInativarColecao, colecao: this.props.colecao });
	            }

	            return React.createElement(
	                'e',
	                null,
	                btnStatus
	            );
	        }

	    });

	    var ColecoesList = React.createClass({
	        displayName: 'ColecoesList',

	        getInitialState: function () {
	            return { data: [] };
	        },
	        load: function () {
	            var _this = this;
	            $.get(_this.props.source, function (result) {
	                _this.setState({ data: result });
	            }.bind(_this));
	        },
	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {

	            var _this = this;

	            return React.createElement(
	                'span',
	                null,
	                this.state.data.map(function (colecao) {
	                    var categoriasUrl = "/user/collection/" + colecao.id + "-" + colecao.nome.toLowerCase().replace(/ /g, '_') + "/categories";
	                    return React.createElement(
	                        'div',
	                        { key: colecao.id },
	                        React.createElement(BlockColecoes, { colecao: colecao,
	                            dirImg: dirImg,
	                            categoriasUrl: categoriasUrl,
	                            defaultImage: defaultImage,
	                            reloadColecao: _this.load,
	                            user: user
	                        })
	                    );
	                })
	            );
	        }
	    });

	    var source = $("#colecoes").attr("data-source");
	    var dirImg = $("#colecoes").attr("data-img");
	    var defaultImage = $("#colecoes").attr("data-defaul-image");
	    var user = $("#colecoes").attr("data-user");

	    if (document.getElementById("colecoes")) {
	        ReactDOM.render(React.createElement(
	            'div',
	            null,
	            React.createElement(ColecoesList, { source: source, dirImg: dirImg, defaultImage: defaultImage, user: user })
	        ), document.getElementById('colecoes'));
	    }
	});

/***/ },
/* 9 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 28/10/16.
	 */

	$(function () {

	    const ROLE_ADMIN = "ROLE_ADMIN";

	    class BtnAdd extends React.Component {

	        render() {

	            const url = "/user/praise/new?category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar Musica"
	            );
	        }

	    }

	    class BtnAdd2 extends React.Component {

	        render() {

	            const url = "/user/praise/new?various=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar V\xE1rias Musica"
	            );
	        }

	    }

	    class BtnAdd3 extends React.Component {

	        render() {

	            const url = "/user/praise/new?various=1&same_category=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar V\xE1rias Musica"
	            );
	        }

	    }

	    class BtnEditar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { href: this.props.link, className: "button is-info is-inverted is-small" },
	                "Editar"
	            );
	        }

	    }

	    class BtnInativar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-danger is-inverted is-small" },
	                "Inativar"
	            );
	        }
	    }
	    ;

	    class BtnAtivar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-success is-inverted is-small" },
	                "Ativar"
	            );
	        }
	    }
	    ;

	    class Card extends React.Component {
	        render() {
	            return React.createElement(
	                "div",
	                { className: "media wow fadeInUp animated slide", "data-wow-delay": ".3s" },
	                React.createElement(
	                    "div",
	                    { className: "media-body" },
	                    this.props.children
	                )
	            );
	        }
	    }

	    var MudarStatusMusica = React.createClass({
	        displayName: "MudarStatusMusica",


	        getInitialState: function () {
	            return { ativo: this.props.musica.ativo };
	        },

	        loadStatus: function () {
	            this.props.reloadMusica();
	            this.setState({ ativo: !this.props.musica.ativo });
	        },

	        handleMudarStatus: function (e) {

	            e.preventDefault();

	            const _this = this;

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
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },

	        render: function () {

	            let btn = React.createElement(BtnAtivar, { mudarStatus: this.handleMudarStatus });

	            if (this.props.musica.ativo) {
	                btn = React.createElement(BtnInativar, { mudarStatus: this.handleMudarStatus });
	            }

	            return React.createElement(
	                "span",
	                null,
	                btn
	            );
	        }

	    });

	    var ListMusicas = React.createClass({
	        displayName: "ListMusicas",


	        render: function () {

	            let btnEditar = "";
	            let btnMudarStatus = "";
	            let btnRegistros = "";
	            let btns = "";

	            const _this = this;

	            return React.createElement(
	                "div",
	                null,
	                this.props.data.map(function (musica) {

	                    let linkAnexos = "/user/praise/" + musica.id + '-' + musica.nome.toLowerCase().replace(/ /g, '_') + "/attachments";
	                    let editarMusica = "/user/praises/" + musica.id + "-" + musica.nome.toLowerCase().replace(/ /g, '_') + "/edit";

	                    if (ROLE_ADMIN == _this.props.user) {
	                        btnEditar = React.createElement(BtnEditar, { link: editarMusica });
	                        btnMudarStatus = React.createElement(MudarStatusMusica, { musica: musica, reloadMusica: _this.props.reloadMusicas });
	                        btnRegistros = React.createElement(
	                            "span",
	                            { className: "tag is-light" },
	                            musica.qtde_anexos
	                        );

	                        btns = React.createElement(
	                            "div",
	                            { className: "control is-grouped is-centered" },
	                            React.createElement(
	                                "p",
	                                { className: "control" },
	                                React.createElement(MudarStatusMusica, { musica: musica, reloadMusica: _this.props.reloadMusicas })
	                            ),
	                            React.createElement(
	                                "p",
	                                { className: "control" },
	                                React.createElement(BtnEditar, { link: editarMusica })
	                            ),
	                            React.createElement(
	                                "p",
	                                { className: "control" },
	                                React.createElement(
	                                    "span",
	                                    { className: "tag is-light" },
	                                    musica.qtde_anexos
	                                )
	                            )
	                        );
	                    }

	                    let musicaStr = musica.nome;

	                    if (musica.numero) {
	                        musicaStr = musica.numero + ' - ' + musica.nome;
	                    }

	                    return React.createElement(
	                        "div",
	                        { key: musica.id },
	                        React.createElement(
	                            "div",
	                            { className: "col-sm-6 col-xs-12" },
	                            React.createElement(
	                                "figure",
	                                { className: "wow fadeInLeft animated portfolio-item" },
	                                React.createElement(
	                                    "figcaption",
	                                    null,
	                                    React.createElement(
	                                        "h2",
	                                        { className: "tile" },
	                                        React.createElement(
	                                            "a",
	                                            { href: linkAnexos },
	                                            musicaStr
	                                        )
	                                    ),
	                                    btns
	                                )
	                            )
	                        )
	                    );
	                })
	            );
	        }
	    });

	    var View = React.createClass({
	        displayName: "View",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get(this.props.source, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        openModal: function () {
	            $("#musica-modal").modal("show");
	        },

	        closeModal: function () {
	            $("#musica-modal").modal("hide");
	        },

	        render: function () {

	            let addMusica = React.createElement(BtnAdd, { categoria: this.props.categoria, categoriaNome: this.props.categoriaNome });
	            let addMusica2 = '';
	            let addMusica3 = '';

	            if (ROLE_ADMIN == this.props.user) {
	                addMusica2 = React.createElement(BtnAdd2, { categoria: this.props.categoria, categoriaNome: this.props.categoriaNome });
	                addMusica3 = React.createElement(BtnAdd3, { categoria: this.props.categoria, categoriaNome: this.props.categoriaNome });
	            }

	            return React.createElement(
	                Base,
	                null,
	                addMusica,
	                addMusica2,
	                addMusica3,
	                React.createElement(GerenciarModal, { closeModal: this.closeModal, reloadMusicas: this.load, colecao: this.props.colecao,
	                    categoria: this.props.categoria }),
	                React.createElement("hr", { className: "small" }),
	                React.createElement(ListMusicas, { data: this.state.data, user: this.props.user, reloadMusicas: this.load })
	            );
	        }

	    });

	    const Modal = React.createClass({
	        displayName: "Modal",


	        componentDidMount: function () {
	            $(this.getDOMNode).modal({ backdrop: "static", keyboard: true, show: false });
	        },

	        componentWillUnmount: function () {
	            $(this.getDOMNode).off("hidden", this.handleHidden);
	        },

	        open: function () {
	            $(this.getDOMNode).modal("show");
	        },

	        close: function () {
	            $(this.getDOMNode).modal("hide");
	        },

	        render: function () {
	            return React.createElement(
	                "div",
	                { id: "musica-modal", className: "modal fade", tabIndex: "-1" },
	                React.createElement(
	                    "div",
	                    { className: "modal-dialog" },
	                    React.createElement(
	                        "div",
	                        { className: "modal-content" },
	                        React.createElement(
	                            "div",
	                            { className: "modal-header" },
	                            React.createElement(
	                                "button",
	                                { type: "button", className: "close", "data-dismiss": "modal" },
	                                React.createElement(
	                                    "span",
	                                    null,
	                                    "\xD7"
	                                )
	                            ),
	                            React.createElement(
	                                "h4",
	                                { className: "modal-title" },
	                                this.props.title
	                            )
	                        ),
	                        React.createElement(
	                            "form",
	                            { className: "form-horizontal", onSubmit: this.props.handleSubmit },
	                            React.createElement(
	                                "div",
	                                { className: "modal-body" },
	                                this.props.children
	                            ),
	                            React.createElement(
	                                "div",
	                                { className: "modal-footer" },
	                                React.createElement(
	                                    "button",
	                                    { type: "button", className: "button is-danger is-outlined is-pulled-left",
	                                        "data-dismiss": "modal" },
	                                    "Cancelar"
	                                ),
	                                React.createElement(
	                                    "button",
	                                    { type: "submit", className: "button is-success" },
	                                    "Salvar"
	                                )
	                            )
	                        )
	                    )
	                )
	            );
	        }
	    });

	    const GerenciarModal = React.createClass({
	        displayName: "GerenciarModal",


	        getInitialState: function () {
	            return { data: [], albuns: [] };
	        },

	        load: function () {

	            $.get('/user/tonalidades', function (result) {
	                this.setState({ data: result });
	            }.bind(this));

	            $.get('/user/albuns', function (result) {
	                this.setState({ albuns: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        handleSubmit: function (e) {

	            var _this = this;

	            e.preventDefault();

	            var nome = this.refs.nome.value.trim();
	            var numero = this.refs.numero.value.trim();
	            var tonalidade = this.refs.tonalidade.value.trim();
	            var album = this.refs.album.value.trim();
	            var categoria = $("#musicas").data("categoria");

	            if (!nome || !categoria) {
	                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
	                return false;
	            }

	            $.ajax({
	                type: "POST",
	                url: "/user/musica/adicionar",
	                data: {
	                    nome: nome,
	                    numero: numero,
	                    tonalidade: tonalidade,
	                    album: album,
	                    categoria: categoria
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

	        render: function () {

	            var modal = null;
	            modal = React.createElement(
	                Modal,
	                { title: "Adicionar Musica", handleSubmit: this.handleSubmit },
	                React.createElement(
	                    "label",
	                    { htmlFor: "nome" },
	                    "Nome"
	                ),
	                React.createElement("input", { className: "input", type: "text", name: "nome", ref: "nome", id: "nome", required: true }),
	                React.createElement(
	                    "label",
	                    { htmlFor: "numero" },
	                    "N\xFAmero"
	                ),
	                React.createElement("input", { className: "input", type: "text", name: "numero", id: "numero", ref: "numero" }),
	                React.createElement(
	                    "label",
	                    { htmlFor: "tonalidade" },
	                    "Tonalidade"
	                ),
	                React.createElement(
	                    "select",
	                    { className: "form-control", name: "tonalidade", ref: "tonalidade", id: "tonalidade" },
	                    this.state.data.map(function (tom) {
	                        return React.createElement(
	                            "option",
	                            { key: tom, value: tom },
	                            tom
	                        );
	                    })
	                ),
	                React.createElement(
	                    "label",
	                    { htmlFor: "album" },
	                    "Album"
	                ),
	                React.createElement(
	                    "select",
	                    { className: "form-control", name: "album", ref: "album", id: "album" },
	                    React.createElement(
	                        "option",
	                        { value: "" },
	                        "Sem Album"
	                    ),
	                    this.state.albuns.map(function (album) {
	                        return React.createElement(
	                            "option",
	                            { key: album.id, value: album.id },
	                            album.label
	                        );
	                    })
	                )
	            );

	            return React.createElement(
	                "div",
	                null,
	                modal
	            );
	        }
	    });

	    class Base extends React.Component {
	        render() {
	            return React.createElement(
	                "article",
	                null,
	                React.createElement(
	                    "div",
	                    { className: "container" },
	                    React.createElement(
	                        "div",
	                        { className: "row" },
	                        React.createElement(
	                            "div",
	                            { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                            this.props.children
	                        )
	                    )
	                )
	            );
	        }
	    }

	    var source = $("#musicas").attr("data-source");
	    var sourceLink = $("#musicas").attr("data-add-musica");
	    var user = $("#musicas").attr("data-user");
	    var colecao = $("#musicas").data("colecao");
	    var categoria = $("#musicas").data("categoria");
	    var categoriaNome = $("#musicas").data("categoria-nome");

	    if (document.getElementById("musicas")) {
	        ReactDOM.render(React.createElement(
	            "div",
	            null,
	            React.createElement(View, { source: source, link: sourceLink, user: user, colecao: colecao, categoria: categoria,
	                categoriaNome: categoriaNome })
	        ), document.getElementById('musicas'));
	    }
	});

/***/ },
/* 10 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 28/10/16.
	 */

	$(function () {

	    const ROLE_ADMIN = "ROLE_ADMIN";

	    class BtnAdd extends React.Component {

	        render() {

	            const url = "/user/praise/new?category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar Musica"
	            );
	        }

	    }

	    class BtnAdd2 extends React.Component {

	        render() {

	            const url = "/user/praise/new?various=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar V\xE1rias Musica"
	            );
	        }

	    }

	    class BtnAdd3 extends React.Component {

	        render() {

	            const url = "/user/praise/new?various=1&same_category=1&category_id=" + this.props.categoria + "&category_name=" + this.props.categoriaNome.toLowerCase().replace(/ /g, '_');

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar V\xE1rias Musica"
	            );
	        }

	    }

	    class BtnEditar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { href: this.props.link, className: "button is-info is-inverted is-small" },
	                "Editar"
	            );
	        }

	    }

	    class BtnInativar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-danger is-inverted is-small" },
	                "Inativar"
	            );
	        }
	    };

	    class BtnAtivar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-success is-inverted is-small" },
	                "Ativar"
	            );
	        }
	    };

	    class Card extends React.Component {
	        render() {
	            return React.createElement(
	                "div",
	                { className: "media wow fadeInUp animated slide", "data-wow-delay": ".3s" },
	                React.createElement(
	                    "div",
	                    { className: "media-body" },
	                    this.props.children
	                )
	            );
	        }
	    }

	    var MudarStatusMusica = React.createClass({
	        displayName: "MudarStatusMusica",


	        getInitialState: function () {
	            return { ativo: this.props.musica.ativo };
	        },

	        loadStatus: function () {
	            this.props.reloadMusica();
	            this.setState({ ativo: !this.props.musica.ativo });
	        },

	        handleMudarStatus: function (e) {

	            e.preventDefault();

	            const _this = this;

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
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },

	        render: function () {

	            let btn = React.createElement(BtnAtivar, { mudarStatus: this.handleMudarStatus });

	            if (this.props.musica.ativo) {
	                btn = React.createElement(BtnInativar, { mudarStatus: this.handleMudarStatus });
	            }

	            return React.createElement(
	                "span",
	                null,
	                btn
	            );
	        }

	    });

	    class BtnFavoritos extends React.Component {

	        render() {

	            let btn = React.createElement(
	                "a",
	                { className: "button is-small is-danger is-inverted add-remove",
	                    onClick: this.props.handleFavoritos
	                },
	                "Remover dos Favoritos"
	            );

	            return React.createElement(
	                "span",
	                null,
	                btn
	            );
	        }
	    }

	    const ListMusicas = React.createClass({
	        displayName: "ListMusicas",


	        handleFavoritos: function (e) {

	            e.preventDefault();

	            alert(e.target.musica);

	            const _this = this;

	            let id = this.props.musica;

	            $("#add-remove").addClass("is-loading");

	            block_screen(500);

	            $.ajax({
	                type: "POST",
	                url: "/api/favoritos/add-remove",
	                data: {
	                    "id": id
	                },
	                cache: false,
	                success: function (data) {
	                    $("#add-remove").removeClass("is-loading");
	                    unblock_screen();
	                    alertify.success(data.mensagem);
	                    _this.loadFavoritos();
	                },
	                error: function () {
	                    $("#add-remove").removeClass("is-loading");
	                    unblock_screen();
	                    alertify.error("Ocorreu um erro.");
	                }
	            });
	        },

	        render: function () {

	            let btnEditar = "";
	            let btnMudarStatus = "";
	            let btnRemoverDosFavoritos = "";
	            const _this = this;

	            return React.createElement(
	                "div",
	                null,
	                this.props.data.map(function (favorito) {

	                    let linkAnexos = "/user/praise/" + favorito.musica.id + '-' + favorito.musica.nome.toLowerCase().replace(/ /g, '_') + "/attachments";
	                    let editarMusica = "/user/praises/" + favorito.musica.id + "-" + favorito.musica.nome.toLowerCase().replace(/ /g, '_') + "/edit";

	                    if (ROLE_ADMIN == _this.props.user) {
	                        btnEditar = React.createElement(BtnEditar, { link: editarMusica });
	                        btnMudarStatus = React.createElement(MudarStatusMusica, { musica: favorito.musica, reloadMusica: _this.props.reloadMusicas });
	                    }
	                    /*
	                                                btnRemoverDosFavoritos = (
	                                                    <BtnFavoritos musica={favorito.musica} handleFavoritos={_this.handleFavoritos}/>
	                                                );
	                    */
	                    let musicaStr = favorito.musica.nome;

	                    if (favorito.musica.numero) {
	                        musicaStr = favorito.musica.numero + ' - ' + favorito.musica.nome;
	                    }

	                    return React.createElement(
	                        "div",
	                        { key: favorito.musica.id },
	                        React.createElement(
	                            "h4",
	                            { className: "media-heading" },
	                            React.createElement(
	                                "a",
	                                { href: linkAnexos },
	                                musicaStr,
	                                " ",
	                                React.createElement(
	                                    "span",
	                                    { className: "tag is-light is-pulled-right" },
	                                    favorito.musica.qtde_anexos
	                                )
	                            )
	                        ),
	                        btnRemoverDosFavoritos,
	                        btnEditar,
	                        btnMudarStatus,
	                        React.createElement("hr", null)
	                    );
	                })
	            );
	        }
	    });

	    const View = React.createClass({
	        displayName: "View",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get(this.props.source, function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        render: function () {
	            return React.createElement(
	                Base,
	                null,
	                React.createElement(ListMusicas, { data: this.state.data, user: this.props.user, reloadMusicas: this.load })
	            );
	        }
	    });

	    class Base extends React.Component {
	        render() {
	            return React.createElement(
	                "article",
	                null,
	                React.createElement(
	                    "div",
	                    { className: "container" },
	                    React.createElement(
	                        "div",
	                        { className: "row" },
	                        React.createElement(
	                            "div",
	                            { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                            this.props.children
	                        )
	                    )
	                )
	            );
	        }
	    }

	    const source = $("#favoritos").attr("data-source");
	    const user = $("#favoritos").attr("data-user");

	    if (document.getElementById("favoritos")) {
	        ReactDOM.render(React.createElement(
	            "div",
	            null,
	            React.createElement(View, { source: source, user: user })
	        ), document.getElementById('favoritos'));
	    }
	});

/***/ },
/* 11 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 25/01/17.
	 */

	class Container extends React.Component {

	    render() {
	        return React.createElement(
	            "article",
	            null,
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }

	};

	const Render = React.createClass({
	    displayName: "Render",


	    getInitialState: function () {
	        return { data: [], colecao: [] };
	    },

	    load: function () {
	        $.get('/api/colecoes', function (result) {
	            this.setState({ data: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    redirect: function () {
	        return window.location.href = '/user/collection/' + this.props.colecaoId + '-' + this.props.colecaoNome + '/categories';
	    },

	    handleSubmit: function (e) {

	        e.preventDefault();

	        let nome = this.refs.nome.value.trim();
	        let colecao = this.refs.colecao.value.trim();

	        if (!nome || !colecao) {
	            alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
	        }

	        const _this = this;

	        $.ajax({
	            type: "POST",
	            url: "/api/categoria/adicionar",
	            data: {
	                nome: nome,
	                colecao: colecao
	            },
	            cache: false,
	            success: function (data) {
	                alertify.success(data.mensagem);
	                unblock_screen();
	                _this.redirect();
	            },
	            error: function (data) {
	                unblock_screen();
	                alertify.error(data.mensagem);
	            }
	        });
	    },

	    render: function () {
	        return React.createElement(
	            Container,
	            null,
	            React.createElement(
	                "form",
	                { onSubmit: this.handleSubmit },
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Nome"
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement("input", { className: "input", type: "text", placeholder: "Nome", autoFocus: "autoFocus", ref: "nome", name: "nome", id: "nome", required: true })
	                ),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Cole\xE7\xE3o"
	                ),
	                React.createElement(
	                    "div",
	                    { className: "select is-fullwidth" },
	                    React.createElement(
	                        "select",
	                        { ref: "colecao", name: "colecao", id: "colecao", defaultValue: this.props.colecaoId },
	                        this.state.data.map(function (colecao) {
	                            return React.createElement(
	                                "option",
	                                { key: colecao.id, value: colecao.id },
	                                colecao.nome
	                            );
	                        })
	                    )
	                ),
	                React.createElement("br", null),
	                React.createElement("br", null),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "button",
	                        { className: "button is-fullwidth is-danger" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }
	});

	if (document.getElementById("categoria-adicionar")) {

	    const colecaoId = $("#categoria-adicionar").data("colecao-id");
	    const colecaoNome = $("#categoria-adicionar").data("colecao-nome");

	    ReactDOM.render(React.createElement(Render, {
	        colecaoId: colecaoId,
	        colecaoNome: colecaoNome
	    }), document.getElementById('categoria-adicionar'));
	}

/***/ },
/* 12 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 25/01/17.
	 */

	class Container extends React.Component {

	    render() {
	        return React.createElement(
	            "article",
	            null,
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }

	};

	const Render = React.createClass({
	    displayName: "Render",


	    getInitialState: function () {
	        return { data: [], colecao: [] };
	    },

	    load: function () {
	        $.get('/api/colecoes', function (result) {
	            this.setState({ data: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    redirect: function () {
	        return window.location.href = '/user/collection/' + this.props.colecaoId + '-' + this.props.colecaoNome + '/categories';
	    },

	    handleSubmit: function (e) {

	        e.preventDefault();

	        let id = this.refs.id.value.trim();
	        let nome = this.refs.nome.value.trim();
	        let colecao = this.refs.colecao.value.trim();

	        if (!nome || !colecao) {
	            alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
	        }

	        const _this = this;

	        $.ajax({
	            type: "POST",
	            url: "/api/category/edit",
	            data: {
	                id: id,
	                nome: nome,
	                colecao: colecao
	            },
	            cache: false,
	            success: function (data) {
	                alertify.success(data.mensagem);
	                unblock_screen();
	                _this.redirect();
	            },
	            error: function (data) {
	                unblock_screen();
	                alertify.error(data.mensagem);
	            }
	        });
	    },

	    render: function () {
	        return React.createElement(
	            Container,
	            null,
	            React.createElement(
	                "form",
	                { onSubmit: this.handleSubmit },
	                React.createElement("input", { type: "hidden", name: "id", ref: "id", id: "id", value: this.props.categoriaId }),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Nome"
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement("input", { className: "input", type: "text", placeholder: "Nome", autoFocus: "autoFocus", ref: "nome",
	                        name: "nome", id: "nome", required: true, defaultValue: this.props.categoriaNome })
	                ),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Cole\xE7\xE3o"
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "div",
	                        { className: "select is-fullwidth" },
	                        React.createElement(
	                            "select",
	                            { ref: "colecao", name: "colecao", id: "colecao", defaultValue: this.props.colecaoId },
	                            this.state.data.map(function (colecao) {
	                                return React.createElement(
	                                    "option",
	                                    { key: colecao.id, value: colecao.id },
	                                    colecao.nome
	                                );
	                            })
	                        )
	                    )
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "button",
	                        { className: "button is-fullwidth is-primary" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }
	});

	if (document.getElementById("categoria-editar")) {

	    const categoriaId = $("#categoria-editar").data("categoria-id");
	    const categoriaNome = $("#categoria-editar").data("categoria-nome");

	    const colecaoId = $("#categoria-editar").data("colecao-id");
	    const colecaoNome = $("#categoria-editar").data("colecao-nome");

	    ReactDOM.render(React.createElement(Render, {
	        categoriaId: categoriaId,
	        categoriaNome: categoriaNome,
	        colecaoId: colecaoId,
	        colecaoNome: colecaoNome
	    }), document.getElementById('categoria-editar'));
	}

/***/ },
/* 13 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 25/01/17.
	 */

	class Container extends React.Component {

	    render() {
	        return React.createElement(
	            "article",
	            null,
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }

	}
	;

	const Render = React.createClass({
	    displayName: "Render",


	    getInitialState: function () {
	        return { data: [], categorias: [], categoria: [], tons: [] };
	    },

	    load: function () {
	        $.get('/user/categorias', function (result) {
	            this.setState({ categorias: result });
	        }.bind(this));

	        $.get('/user/tonalidades', function (result) {
	            this.setState({ tons: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    handleSubmit: function (e) {

	        e.preventDefault();

	        let nome = this.refs.nome.value.trim();
	        let numero = this.refs.numero.value.trim();
	        let tonalidade = this.refs.tonalidade.value.trim();
	        let categoria = this.refs.categoria.value.trim();

	        if (!nome || !categoria) {
	            alertify.error("O Nome da Musica e a Categoria devem ser informadas.");
	        }

	        let categoriaID = this.refs.categoria.value;
	        let categoriaNome = "category";
	        const PRAISES = '/user/category/' + categoriaID + '-' + categoriaNome + '/praises';

	        $.ajax({
	            type: "POST",
	            url: "/api/musica/adicionar",
	            data: {
	                nome: nome,
	                numero: numero,
	                tonalidade: tonalidade,
	                categoria: categoria
	            },
	            cache: false,
	            success: function (data) {

	                if (data.classe == 'success') {
	                    alertify.success(data.message);
	                } else {
	                    alertify.error(data.message);
	                }

	                if (data.redirect == true) {
	                    window.location.href = '/user/praise-success';
	                } else if (data.classe == 'sucess') {
	                    window.location.href = PRAISES;
	                }
	                unblock_screen();
	            },
	            error: function (data) {
	                alertify.error(data.message);
	                unblock_screen();
	            }
	        });
	    },

	    render: function () {

	        return React.createElement(
	            Container,
	            null,
	            React.createElement(
	                "form",
	                { className: "form-horizontal", method: "POST", onSubmit: this.handleSubmit },
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Titulo"
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome", name: "nome", id: "nome", required: true })
	                ),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "N\xFAmero:"
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement("input", { className: "input", type: "text", placeholder: "N\xFAmero", ref: "numero", name: "numero", id: "numero" })
	                ),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Tonalidade"
	                ),
	                React.createElement(
	                    "div",
	                    { className: "select is-fullwidth" },
	                    React.createElement(
	                        "select",
	                        { name: "tonalidade", ref: "tonalidade", id: "tonalidade" },
	                        this.state.tons.map(function (tom) {
	                            return React.createElement(
	                                "option",
	                                { key: tom, defaultValue: tom },
	                                tom
	                            );
	                        })
	                    )
	                ),
	                React.createElement(
	                    "label",
	                    { className: "label text-black" },
	                    "Categoria"
	                ),
	                React.createElement(
	                    "div",
	                    { className: "select is-fullwidth" },
	                    React.createElement(
	                        "select",
	                        { id: "categoria", name: "categoria", ref: "categoria", defaultValue: this.props.categoria, required: true },
	                        this.state.categorias.map(function (colecao) {
	                            return React.createElement(
	                                "optgroup",
	                                { key: colecao.nome, label: colecao.nome },
	                                colecao.categorias.map(function (categoria) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: categoria.id, value: categoria.id },
	                                        categoria.nome
	                                    );
	                                })
	                            );
	                        })
	                    )
	                ),
	                React.createElement("br", null),
	                React.createElement("br", null),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "button",
	                        { className: "button is-danger is-fullwidth", type: "submit" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }
	});

	if (document.getElementById("musica-adicionar")) {

	    const categoria = $("#musica-adicionar").data("categoria");

	    ReactDOM.render(React.createElement(Render, { categoria: categoria }), document.getElementById('musica-adicionar'));
	}

/***/ },
/* 14 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 25/01/17.
	 */

	class Container extends React.Component {

	    render() {
	        return React.createElement(
	            "article",
	            null,
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }

	}
	;

	const Render = React.createClass({
	    displayName: "Render",


	    getInitialState: function () {
	        return { data: [], categorias: [], categoria: [], tons: [] };
	    },

	    load: function () {
	        $.get('/user/categorias', function (result) {
	            this.setState({ categorias: result });
	        }.bind(this));

	        $.get('/user/tonalidades', function (result) {
	            this.setState({ tons: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    handleSubmit: function (e) {

	        e.preventDefault();

	        let nome1 = this.refs.nome1.value.trim();
	        let numero1 = this.refs.numero1.value.trim();
	        let tonalidade1 = this.refs.tonalidade1.value.trim();
	        let categoria1 = this.refs.categoria1.value.trim();

	        let nome2 = this.refs.nome2.value.trim();
	        let numero2 = this.refs.numero2.value.trim();
	        let tonalidade2 = this.refs.tonalidade2.value.trim();
	        let categoria2 = this.refs.categoria2.value.trim();

	        let nome3 = this.refs.nome3.value.trim();
	        let numero3 = this.refs.numero3.value.trim();
	        let tonalidade3 = this.refs.tonalidade3.value.trim();
	        let categoria3 = this.refs.categoria3.value.trim();

	        let nome4 = this.refs.nome4.value.trim();
	        let numero4 = this.refs.numero4.value.trim();
	        let tonalidade4 = this.refs.tonalidade4.value.trim();
	        let categoria4 = this.refs.categoria4.value.trim();

	        let nome5 = this.refs.nome5.value.trim();
	        let numero5 = this.refs.numero5.value.trim();
	        let tonalidade5 = this.refs.tonalidade5.value.trim();
	        let categoria5 = this.refs.categoria5.value.trim();

	        let nome6 = this.refs.nome6.value.trim();
	        let numero6 = this.refs.numero6.value.trim();
	        let tonalidade6 = this.refs.tonalidade6.value.trim();
	        let categoria6 = this.refs.categoria6.value.trim();

	        let nome7 = this.refs.nome7.value.trim();
	        let numero7 = this.refs.numero7.value.trim();
	        let tonalidade7 = this.refs.tonalidade7.value.trim();
	        let categoria7 = this.refs.categoria7.value.trim();

	        let nome8 = this.refs.nome8.value.trim();
	        let numero8 = this.refs.numero8.value.trim();
	        let tonalidade8 = this.refs.tonalidade8.value.trim();
	        let categoria8 = this.refs.categoria8.value.trim();

	        let nome9 = this.refs.nome9.value.trim();
	        let numero9 = this.refs.numero9.value.trim();
	        let tonalidade9 = this.refs.tonalidade9.value.trim();
	        let categoria9 = this.refs.categoria9.value.trim();

	        let nome10 = this.refs.nome10.value.trim();
	        let numero10 = this.refs.numero10.value.trim();
	        let tonalidade10 = this.refs.tonalidade10.value.trim();
	        let categoria10 = this.refs.categoria10.value.trim();

	        /*
	        if (!nome || !categoria) {
	            alertify.error("O Nome da Musica e a Categoria devem ser informadas.");
	        }
	        */

	        let categoriaID = this.refs.categoria1.value;
	        let categoriaNome = "category";
	        const PRAISES = '/user/category/' + categoriaID + '-' + categoriaNome + '/praises';

	        $.ajax({
	            type: "POST",
	            url: "/api/musica/adicionar/varios",
	            data: {
	                itens: [{ nome: nome1, numero: numero1, tonalidade: tonalidade1, categoria: categoria1 }, { nome: nome2, numero: numero2, tonalidade: tonalidade2, categoria: categoria2 }, { nome: nome3, numero: numero3, tonalidade: tonalidade3, categoria: categoria3 }, { nome: nome4, numero: numero4, tonalidade: tonalidade4, categoria: categoria4 }, { nome: nome5, numero: numero5, tonalidade: tonalidade5, categoria: categoria5 }, { nome: nome6, numero: numero6, tonalidade: tonalidade6, categoria: categoria6 }, { nome: nome7, numero: numero7, tonalidade: tonalidade7, categoria: categoria7 }, { nome: nome8, numero: numero8, tonalidade: tonalidade8, categoria: categoria8 }, { nome: nome9, numero: numero9, tonalidade: tonalidade9, categoria: categoria9 }, { nome: nome10, numero: numero10, tonalidade: tonalidade10, categoria: categoria10 }]
	            },
	            cache: false,
	            success: function (data) {
	                alertify.success(data.message);
	                if (data.classe == 'sucess') {
	                    window.location.href = PRAISES;
	                }
	                unblock_screen();
	            },
	            error: function (data) {
	                alertify.error(data.message);
	                unblock_screen();
	            }
	        });
	    },

	    render: function () {

	        return React.createElement(
	            Container,
	            null,
	            React.createElement(
	                "form",
	                { className: "form-horizontal", method: "POST", onSubmit: this.handleSubmit },
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome1", name: "nome1", id: "nome1" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero1", name: "numero1", id: "numero1" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade1", ref: "tonalidade1", id: "tonalidade1" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria1", name: "categoria1", ref: "categoria1", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome2", name: "nome2", id: "nome2" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero2", name: "numero2", id: "numero2" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade2", ref: "tonalidade2", id: "tonalidade2" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria2", name: "categoria2", ref: "categoria2", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome3", name: "nome3", id: "nome3" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero3", name: "numero3", id: "numero3" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade3", ref: "tonalidade3", id: "tonalidade3" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria3", name: "categoria3", ref: "categoria3", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome4", name: "nome4", id: "nome4" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero4", name: "numero4", id: "numero4" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade4", ref: "tonalidade4", id: "tonalidade4" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria4", name: "categoria4", ref: "categoria4", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome5", name: "nome5", id: "nome5" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero5", name: "numero5", id: "numero5" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade5", ref: "tonalidade5", id: "tonalidade5" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria5", name: "categoria5", ref: "categoria5", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome6", name: "nome6", id: "nome6" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero6", name: "numero6", id: "numero6" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade6", ref: "tonalidade6", id: "tonalidade6" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria6", name: "categoria6", ref: "categoria6", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome7", name: "nome7", id: "nome7" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero7", name: "numero7", id: "numero7" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade7", ref: "tonalidade7", id: "tonalidade7" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria7", name: "categoria7", ref: "categoria7", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome8", name: "nome8", id: "nome8" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero8", name: "numero8", id: "numero8" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade8", ref: "tonalidade8", id: "tonalidade8" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria8", name: "categoria8", ref: "categoria8", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome9", name: "nome9", id: "nome9" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero9", name: "numero9", id: "numero9" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade9", ref: "tonalidade9", id: "tonalidade9" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria9", name: "categoria9", ref: "categoria9", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome10", name: "nome10", id: "nome10" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero10", name: "numero10", id: "numero10" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade10", ref: "tonalidade10", id: "tonalidade10" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { id: "categoria10", name: "categoria10", ref: "categoria10", defaultValue: this.props.categoria },
	                                this.state.categorias.map(function (colecao) {
	                                    return React.createElement(
	                                        "optgroup",
	                                        { label: colecao.nome },
	                                        colecao.categorias.map(function (categoria) {
	                                            return React.createElement(
	                                                "option",
	                                                { key: categoria.id, value: categoria.id },
	                                                categoria.nome
	                                            );
	                                        })
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "button",
	                        { className: "button is-danger is-fullwidth", type: "submit" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }
	});

	if (document.getElementById("musica-adicionar-2")) {

	    const categoria = $("#musica-adicionar").data("categoria");

	    ReactDOM.render(React.createElement(Render, { categoria: categoria }), document.getElementById('musica-adicionar-2'));
	}

/***/ },
/* 15 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 28/10/16.
	 */

	$(function () {

	    const ROLE_ADMIN = "ROLE_ADMIN";

	    class BtnAdd extends React.Component {

	        render() {

	            const url = "/user/praise/new";

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar Musica"
	            );
	        }

	    }

	    class BtnAdd2 extends React.Component {

	        render() {

	            const url = "/user/praise/new?various=1";

	            return React.createElement(
	                "a",
	                { href: url, className: "button is-light is-small" },
	                "Adicionar V\xE1rias Musica"
	            );
	        }

	    }

	    class BtnEditarMusicasAdicionadas extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { href: this.props.link, className: "button is-info is-inverted is-small is-pulled-right" },
	                "Editar"
	            );
	        }

	    }

	    class BtnInativar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-danger is-inverted is-small is-pulled-right" },
	                "Inativar"
	            );
	        }
	    };

	    class BtnAtivar extends React.Component {

	        render() {
	            return React.createElement(
	                "a",
	                { onClick: this.props.mudarStatus, className: "button is-success is-inverted is-small is-pulled-right" },
	                "Ativar"
	            );
	        }
	    };

	    class Card extends React.Component {
	        render() {
	            return React.createElement(
	                "div",
	                { className: "media wow fadeInUp animated slide", "data-wow-delay": ".3s" },
	                React.createElement(
	                    "div",
	                    { className: "media-body" },
	                    this.props.children
	                )
	            );
	        }
	    }

	    var MudarStatusMusicasAdicionadas = React.createClass({
	        displayName: "MudarStatusMusicasAdicionadas",


	        getInitialState: function () {
	            return { ativo: this.props.musica.ativo };
	        },

	        loadStatus: function () {
	            this.props.reloadMusica();
	            this.setState({ ativo: !this.props.musica.ativo });
	        },

	        handleMudarStatus: function (e) {

	            e.preventDefault();

	            const _this = this;

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
	            }).setting("labels", { "ok": "Sim", "cancel": "Cancelar" });
	        },

	        render: function () {

	            let btn = React.createElement(BtnAtivar, { mudarStatus: this.handleMudarStatus });

	            if (this.props.musica.ativo) {
	                btn = React.createElement(BtnInativar, { mudarStatus: this.handleMudarStatus });
	            }

	            return React.createElement(
	                "span",
	                null,
	                btn
	            );
	        }

	    });

	    var ListMusicasAdicionadas = React.createClass({
	        displayName: "ListMusicasAdicionadas",


	        render: function () {

	            let btnEditar = "";
	            let btnMudarStatusMusicasAdicionadas = "";
	            const _this = this;

	            return React.createElement(
	                "div",
	                null,
	                this.props.data.map(function (musica) {

	                    let linkAnexos = "/user/praise/" + musica.id + '-' + musica.nome.toLowerCase().replace(/ /g, '_') + "/attachments";
	                    let editarMusica = "/user/praises/" + musica.id + "-" + musica.nome.toLowerCase().replace(/ /g, '_') + "/edit";

	                    if (ROLE_ADMIN == _this.props.user) {
	                        btnEditar = React.createElement(BtnEditarMusicasAdicionadas, { link: editarMusica });
	                        btnMudarStatusMusicasAdicionadas = React.createElement(MudarStatusMusicasAdicionadas, { musica: musica, reloadMusica: _this.props.reloadMusicas });
	                    }

	                    let musicaStr = musica.nome;

	                    if (musica.numero) {
	                        musicaStr = musica.numero + ' - ' + musica.nome;
	                    }

	                    return React.createElement(
	                        "div",
	                        { key: musica.id },
	                        React.createElement(
	                            "h4",
	                            { className: "media-heading" },
	                            React.createElement(
	                                "a",
	                                { href: linkAnexos },
	                                musicaStr
	                            ),
	                            btnEditar,
	                            btnMudarStatusMusicasAdicionadas
	                        ),
	                        React.createElement("hr", null)
	                    );
	                })
	            );
	        }
	    });

	    var View = React.createClass({
	        displayName: "View",


	        getInitialState: function () {
	            return { data: [] };
	        },

	        load: function () {
	            $.get("/api/praises/added", function (result) {
	                this.setState({ data: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        openModal: function () {
	            $("#musica-modal").modal("show");
	        },

	        closeModal: function () {
	            $("#musica-modal").modal("hide");
	        },

	        render: function () {

	            let addMusica = '';
	            let addMusica2 = '';

	            if (ROLE_ADMIN == this.props.user) {
	                addMusica = React.createElement(BtnAdd, null);
	                addMusica2 = React.createElement(BtnAdd2, null);
	            }

	            return React.createElement(
	                Base,
	                null,
	                addMusica,
	                addMusica2,
	                React.createElement(GerenciarModalMusicasAdicionadas, { closeModal: this.closeModal, reloadMusicas: this.load, colecao: this.props.colecao, categoria: this.props.categoria }),
	                React.createElement("hr", { className: "small" }),
	                React.createElement(ListMusicasAdicionadas, { data: this.state.data, user: this.props.user, reloadMusicas: this.load })
	            );
	        }

	    });

	    const Modal = React.createClass({
	        displayName: "Modal",


	        componentDidMount: function () {
	            $(this.getDOMNode).modal({ backdrop: "static", keyboard: true, show: false });
	        },

	        componentWillUnmount: function () {
	            $(this.getDOMNode).off("hidden", this.handleHidden);
	        },

	        open: function () {
	            $(this.getDOMNode).modal("show");
	        },

	        close: function () {
	            $(this.getDOMNode).modal("hide");
	        },

	        render: function () {
	            return React.createElement(
	                "div",
	                { id: "musica-modal", className: "modal fade", tabIndex: "-1" },
	                React.createElement(
	                    "div",
	                    { className: "modal-dialog" },
	                    React.createElement(
	                        "div",
	                        { className: "modal-content" },
	                        React.createElement(
	                            "div",
	                            { className: "modal-header" },
	                            React.createElement(
	                                "button",
	                                { type: "button", className: "close", "data-dismiss": "modal" },
	                                React.createElement(
	                                    "span",
	                                    null,
	                                    "\xD7"
	                                )
	                            ),
	                            React.createElement(
	                                "h4",
	                                { className: "modal-title" },
	                                this.props.title
	                            )
	                        ),
	                        React.createElement(
	                            "form",
	                            { className: "form-horizontal", onSubmit: this.props.handleSubmit },
	                            React.createElement(
	                                "div",
	                                { className: "modal-body" },
	                                this.props.children
	                            ),
	                            React.createElement(
	                                "div",
	                                { className: "modal-footer" },
	                                React.createElement(
	                                    "button",
	                                    { type: "button", className: "button is-danger is-outlined is-pulled-left", "data-dismiss": "modal" },
	                                    "Cancelar"
	                                ),
	                                React.createElement(
	                                    "button",
	                                    { type: "submit", className: "button is-success" },
	                                    "Salvar"
	                                )
	                            )
	                        )
	                    )
	                )
	            );
	        }
	    });

	    const GerenciarModalMusicasAdicionadas = React.createClass({
	        displayName: "GerenciarModalMusicasAdicionadas",


	        getInitialState: function () {
	            return { data: [], albuns: [] };
	        },

	        load: function () {

	            $.get('/user/tonalidades', function (result) {
	                this.setState({ data: result });
	            }.bind(this));

	            $.get('/user/albuns', function (result) {
	                this.setState({ albuns: result });
	            }.bind(this));
	        },

	        componentDidMount: function () {
	            this.load();
	        },

	        handleSubmit: function (e) {

	            var _this = this;

	            e.preventDefault();

	            var nome = this.refs.nome.value.trim();
	            var numero = this.refs.numero.value.trim();
	            var tonalidade = this.refs.tonalidade.value.trim();
	            var album = this.refs.album.value.trim();
	            var categoria = $("#musicas").data("categoria");

	            if (!nome || !categoria) {
	                alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
	                return false;
	            }

	            $.ajax({
	                type: "POST",
	                url: "/user/musica/adicionar",
	                data: {
	                    nome: nome,
	                    numero: numero,
	                    tonalidade: tonalidade,
	                    album: album,
	                    categoria: categoria
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

	        render: function () {

	            var modal = null;
	            modal = React.createElement(
	                Modal,
	                { title: "Adicionar Musica", handleSubmit: this.handleSubmit },
	                React.createElement(
	                    "label",
	                    { htmlFor: "nome" },
	                    "Nome"
	                ),
	                React.createElement("input", { className: "input", type: "text", name: "nome", ref: "nome", id: "nome", required: true }),
	                React.createElement(
	                    "label",
	                    { htmlFor: "numero" },
	                    "N\xFAmero"
	                ),
	                React.createElement("input", { className: "input", type: "text", name: "numero", id: "numero", ref: "numero" }),
	                React.createElement(
	                    "label",
	                    { htmlFor: "tonalidade" },
	                    "Tonalidade"
	                ),
	                React.createElement(
	                    "select",
	                    { className: "form-control", name: "tonalidade", ref: "tonalidade", id: "tonalidade" },
	                    this.state.data.map(function (tom) {
	                        return React.createElement(
	                            "option",
	                            { key: tom, value: tom },
	                            tom
	                        );
	                    })
	                ),
	                React.createElement(
	                    "label",
	                    { htmlFor: "album" },
	                    "Album"
	                ),
	                React.createElement(
	                    "select",
	                    { className: "form-control", name: "album", ref: "album", id: "album" },
	                    React.createElement(
	                        "option",
	                        { value: "" },
	                        "Sem Album"
	                    ),
	                    this.state.albuns.map(function (album) {
	                        return React.createElement(
	                            "option",
	                            { key: album.id, value: album.id },
	                            album.label
	                        );
	                    })
	                )
	            );

	            return React.createElement(
	                "div",
	                null,
	                modal
	            );
	        }
	    });

	    class Base extends React.Component {
	        render() {
	            return React.createElement(
	                "article",
	                null,
	                React.createElement(
	                    "div",
	                    { className: "container" },
	                    React.createElement(
	                        "div",
	                        { className: "row" },
	                        React.createElement(
	                            "div",
	                            { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                            this.props.children
	                        )
	                    )
	                )
	            );
	        }
	    }

	    var source = $("#musicas-adicionadas").attr("data-source");
	    var user = $("#musicas-adicionadas").attr("data-user");

	    if (document.getElementById("musicas-adicionadas")) {
	        ReactDOM.render(React.createElement(
	            "div",
	            null,
	            React.createElement(View, { source: source, user: user })
	        ), document.getElementById('musicas-adicionadas'));
	    }
	});

/***/ },
/* 16 */
/***/ function(module, exports) {

	/**
	 * Created by cesar on 25/01/17.
	 */

	class Container extends React.Component {

	    render() {
	        return React.createElement(
	            "article",
	            null,
	            React.createElement(
	                "div",
	                { className: "container" },
	                React.createElement(
	                    "div",
	                    { className: "row" },
	                    React.createElement(
	                        "div",
	                        { className: "col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" },
	                        this.props.children
	                    )
	                )
	            )
	        );
	    }

	}
	;

	const Render = React.createClass({
	    displayName: "Render",


	    getInitialState: function () {
	        return { data: [], categorias: [], categoria: [], tons: [] };
	    },

	    load: function () {
	        $.get('/user/categorias', function (result) {
	            this.setState({ categorias: result });
	        }.bind(this));

	        $.get('/user/tonalidades', function (result) {
	            this.setState({ tons: result });
	        }.bind(this));
	    },

	    componentDidMount: function () {
	        this.load();
	    },

	    handleSubmit: function (e) {

	        e.preventDefault();

	        let categoria = this.refs.categoria.value.trim();

	        let nome1 = this.refs.nome1.value.trim();
	        let numero1 = this.refs.numero1.value.trim();
	        let tonalidade1 = this.refs.tonalidade1.value.trim();

	        let nome2 = this.refs.nome2.value.trim();
	        let numero2 = this.refs.numero2.value.trim();
	        let tonalidade2 = this.refs.tonalidade2.value.trim();

	        let nome3 = this.refs.nome3.value.trim();
	        let numero3 = this.refs.numero3.value.trim();
	        let tonalidade3 = this.refs.tonalidade3.value.trim();

	        let nome4 = this.refs.nome4.value.trim();
	        let numero4 = this.refs.numero4.value.trim();
	        let tonalidade4 = this.refs.tonalidade4.value.trim();

	        let nome5 = this.refs.nome5.value.trim();
	        let numero5 = this.refs.numero5.value.trim();
	        let tonalidade5 = this.refs.tonalidade5.value.trim();

	        let nome6 = this.refs.nome6.value.trim();
	        let numero6 = this.refs.numero6.value.trim();
	        let tonalidade6 = this.refs.tonalidade6.value.trim();

	        let nome7 = this.refs.nome7.value.trim();
	        let numero7 = this.refs.numero7.value.trim();
	        let tonalidade7 = this.refs.tonalidade7.value.trim();

	        let nome8 = this.refs.nome8.value.trim();
	        let numero8 = this.refs.numero8.value.trim();
	        let tonalidade8 = this.refs.tonalidade8.value.trim();

	        let nome9 = this.refs.nome9.value.trim();
	        let numero9 = this.refs.numero9.value.trim();
	        let tonalidade9 = this.refs.tonalidade9.value.trim();

	        let nome10 = this.refs.nome10.value.trim();
	        let numero10 = this.refs.numero10.value.trim();
	        let tonalidade10 = this.refs.tonalidade10.value.trim();

	        /*
	        if (!nome || !categoria) {
	            alertify.error("O Nome da Musica e a Categoria devem ser informadas.");
	        }
	        */

	        let categoriaID = this.refs.categoria.value;
	        let categoriaNome = "category";
	        const PRAISES = '/user/category/' + categoriaID + '-' + categoriaNome + '/praises';

	        $.ajax({
	            type: "POST",
	            url: "/api/musica/adicionar/varios",
	            data: {
	                itens: [{ nome: nome1, numero: numero1, tonalidade: tonalidade1, categoria: categoria }, { nome: nome2, numero: numero2, tonalidade: tonalidade2, categoria: categoria }, { nome: nome3, numero: numero3, tonalidade: tonalidade3, categoria: categoria }, { nome: nome4, numero: numero4, tonalidade: tonalidade4, categoria: categoria }, { nome: nome5, numero: numero5, tonalidade: tonalidade5, categoria: categoria }, { nome: nome6, numero: numero6, tonalidade: tonalidade6, categoria: categoria }, { nome: nome7, numero: numero7, tonalidade: tonalidade7, categoria: categoria }, { nome: nome8, numero: numero8, tonalidade: tonalidade8, categoria: categoria }, { nome: nome9, numero: numero9, tonalidade: tonalidade9, categoria: categoria }, { nome: nome10, numero: numero10, tonalidade: tonalidade10, categoria: categoria }]
	            },
	            cache: false,
	            success: function (data) {
	                alertify.success(data.message);
	                if (data.classe == 'sucess') {
	                    window.location.href = PRAISES;
	                }
	                unblock_screen();
	            },
	            error: function (data) {
	                alertify.error(data.message);
	                unblock_screen();
	            }
	        });
	    },

	    render: function () {

	        return React.createElement(
	            Container,
	            null,
	            React.createElement(
	                "form",
	                { className: "form-horizontal", method: "POST", onSubmit: this.handleSubmit },
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome1", name: "nome1", id: "nome1" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero1", name: "numero1", id: "numero1" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade1", ref: "tonalidade1", id: "tonalidade1" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome2", name: "nome2", id: "nome2" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero2", name: "numero2", id: "numero2" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade2", ref: "tonalidade2", id: "tonalidade2" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome3", name: "nome3", id: "nome3" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero3", name: "numero3", id: "numero3" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade3", ref: "tonalidade3", id: "tonalidade3" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome4", name: "nome4", id: "nome4" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero4", name: "numero4", id: "numero4" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade4", ref: "tonalidade4", id: "tonalidade4" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome5", name: "nome5", id: "nome5" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero5", name: "numero5", id: "numero5" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade5", ref: "tonalidade5", id: "tonalidade5" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome6", name: "nome6", id: "nome6" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero6", name: "numero6", id: "numero6" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade6", ref: "tonalidade6", id: "tonalidade6" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome7", name: "nome7", id: "nome7" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero7", name: "numero7", id: "numero7" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade7", ref: "tonalidade7", id: "tonalidade7" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome8", name: "nome8", id: "nome8" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero8", name: "numero8", id: "numero8" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade8", ref: "tonalidade8", id: "tonalidade8" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome9", name: "nome9", id: "nome9" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero9", name: "numero9", id: "numero9" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade9", ref: "tonalidade9", id: "tonalidade9" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "div",
	                    { className: "control is-grouped" },
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", autoFocus: "autoFocus", placeholder: "Titulo", ref: "nome10", name: "nome10", id: "nome10" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement("input", { className: "input", type: "text", size: "20", placeholder: "N\xFAmero", ref: "numero10", name: "numero10", id: "numero10" })
	                    ),
	                    React.createElement(
	                        "p",
	                        { className: "control is-expanded" },
	                        React.createElement(
	                            "div",
	                            { className: "select is-fullwidth" },
	                            React.createElement(
	                                "select",
	                                { name: "tonalidade10", ref: "tonalidade10", id: "tonalidade10" },
	                                this.state.tons.map(function (tom) {
	                                    return React.createElement(
	                                        "option",
	                                        { key: tom, defaultValue: tom },
	                                        tom
	                                    );
	                                })
	                            )
	                        )
	                    )
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control is-expanded" },
	                    React.createElement(
	                        "div",
	                        { className: "select is-fullwidth" },
	                        React.createElement(
	                            "select",
	                            { id: "categoria", name: "categoria", ref: "categoria", defaultValue: this.props.categoria },
	                            this.state.categorias.map(function (colecao) {
	                                return React.createElement(
	                                    "optgroup",
	                                    { label: colecao.nome },
	                                    colecao.categorias.map(function (categoria) {
	                                        return React.createElement(
	                                            "option",
	                                            { key: categoria.id, value: categoria.id },
	                                            categoria.nome
	                                        );
	                                    })
	                                );
	                            })
	                        )
	                    )
	                ),
	                React.createElement(
	                    "p",
	                    { className: "control" },
	                    React.createElement(
	                        "button",
	                        { className: "button is-danger is-fullwidth", type: "submit" },
	                        "Salvar"
	                    )
	                )
	            )
	        );
	    }
	});

	if (document.getElementById("musica-adicionar-mesma-categoria")) {

	    const categoria = $("#musica-adicionar-mesma-categoria").data("categoria");

	    ReactDOM.render(React.createElement(Render, { categoria: categoria }), document.getElementById('musica-adicionar-mesma-categoria'));
	}

/***/ }
/******/ ]);