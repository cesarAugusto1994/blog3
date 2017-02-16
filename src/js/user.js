/**
 * Created by cesar on 31/10/16.
 */


$(function () {

    class CardHero extends React.Component{
        render() {
            return (
                <section id="hero-area">
                    <div className="row">
                        <div className="col-md-12 text-center">
                            <div className="block wow fadeInUp">
                                <section className="cd-intro">
                                    <h1 className="wow fadeInUp animated cd-headline slide" data-wow-delay=".2s">
                                        <span>Ol&aacute;, {this.props.user}.</span><br />
                                    </h1>
                                </section>
                                <div className="container is-half">
                                    <h2 className="wow fadeInUp animated" data-wow-delay=".2s">
                                        {this.props.app}
                                    </h2>
                                </div>
                                <a className="btn-lines dark light wow fadeInUp animated smooth-scroll btn btn-default btn-green"
                                   data-wow-delay=".3s" href="#works" data-section="#works">Iniciar</a>
                            </div>
                        </div>
                    </div>
                </section>
            );
        }
    }
   
    class Card extends React.Component{
        render() {
            return (
                <section id="works" className="works">
                    <div className="container">
                        <div className="section-heading">
                            <h1 className="title wow fadeInDown" data-wow-delay=".1s">{this.props.sectionName}</h1>
                        </div>
                        <div className="row">
                            {this.props.children}
                        </div>
                    </div>
                </section>
            );
        }
    }

    class CardBlue extends React.Component{
        render() {
            return (
                <section id="call-to-action">
                    <div className="container">
                        <div className="col-md-12">
                            <div className="block">
                                <h2 className="title wow fadeInDown" data-wow-delay=".1s">{this.props.sectionName}</h2>
                                <div className="row">
                                    {this.props.children}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            );
        }
    }

    const StyleImg = {
        minHeight: '160px',
        maxHeight: '160px',
        margin: 'auto'
    };
    
    var Menu = React.createClass({
       
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
                <div>
                    <Card sectionName="Inicio">
                    { this.state.data.map(function (menu) {

                        root = _this.props.dirMenu + menu.icon;

                        return (
                            <div key={menu.id} className="col-sm-4 col-xs-12">
                                <figure className="wow fadeInLeft animated portfolio-item">
                                    <div className="img-wrapper">
                                        <a href={menu.url}>
                                            <img style={StyleImg} src={root} className="img-responsive" alt="this is a title" />
                                                <div className="overlay"></div>
                                        </a>
                                    </div>
                                    <figcaption>
                                        <h4>
                                            <a href={menu.url}>
                                                {menu.nome}
                                            </a>
                                        </h4>
                                        <p>
                                            {menu.descricao}
                                        </p>
                                    </figcaption>
                                </figure>
                            </div>
                        )
                    }) }
                        </Card>
                </div>
            )
        }
        
    });

    var Colecao = React.createClass({

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
                <div>
                    <Card sectionName="Cole&ccedil;&otilde;es">
                        { this.state.data.map(function (colecao) {

                            root = colecao.imagem ? _this.props.dirColecao + colecao.imagem : defaultBackground;
                            linkToCategorias = "/user/collection/" + colecao.id + "-" + colecao.nome.toLowerCase().replace(/ /g, '_') + "/categories";

                            return (
                                <div key={colecao.id} className="col-sm-4 col-xs-12">
                                    <figure className="wow fadeInLeft animated portfolio-item">
                                        <div className="img-wrapper">
                                            <a href={linkToCategorias}>
                                                <img style={StyleImg} src={root} className="img-responsive" alt="this is a title" />
                                                <div className="overlay"></div>
                                            </a>
                                        </div>
                                        <figcaption>
                                            <h4>
                                                <a href={linkToCategorias}>
                                                    {colecao.nome}
                                                </a>
                                            </h4>
                                            <p>
                                                {colecao.descricao}
                                            </p>
                                        </figcaption>
                                    </figure>
                                </div>
                            )
                        }) }
                    </Card>
                </div>
            )
        }

    });

    var Musica = React.createClass({

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
                <div>
                    <Card sectionName="Adicionadas Recentemente">
                        { this.state.data.map(function (musica) {

                            linkToAnexos = "/user/praise/"+musica.id+"-"+musica.nome.toLowerCase().replace(/ /g, '_')+"/attachments";

                            return (

                                <div key={musica.id} className="col-md-4 col-lg-4 col-xs-12">
                                    <div className="media wow fadeInDown animated">
                                        <div className="media-left">
                                            <div className="icon">
                                                <i className="ion-ios-play"></i>
                                            </div>
                                        </div>
                                        <div className="media-body">
                                            <h4 className="media-heading"><a href={linkToAnexos}>{ musica.nome }</a></h4>
                                        </div>
                                    </div>
                                </div>
                                
                            )
                        }) }
                    </Card>
                </div>
            )
        }

    });

    const Videos = React.createClass({

        render : function () {

            return (
                <div>
                    <CardBlue sectionName="Videos">
                        <a href="/user/musica/anexos/videos" className="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Acessar</a>
                    </CardBlue>
                </div>
            )
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
        ReactDOM.render(
            <div>
                <CardHero defaultBackground={defaultBackground} user={user} app={app}/>
                <Colecao source={colecao} dirColecao={dirColecao} defaultBackground={defaultBackground}/>
                <Musica source={musica}/>
                <Videos source={videos}/>
            </div>,
            document.getElementById('user')
        );
    }
});