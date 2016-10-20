/**
 * Created by cesar on 20/10/16.
 */


Image = React.createClass({
    render : function () {
        return (
            <a href={this.props.categoriasUrl}>
                <img className="img-responsive" value="min-height: 160px; max-height: 160px; margin: auto;" src={this.props.dirImg + '' + this.props.colecao.imagem} alt={this.props.colecao.name} />
            </a>
        )
    }
});


Figure = React.createClass({

    render : function () {
        return (
            <figure className="wow fadeInLeft animated portfolio-item" data-wow-duration="500ms" data-wow-delay="0ms">
                <div className="img-wrapper" >
                    <Image colecao={this.props.colecao} dirImg={this.props.dirImg} categoriasUrl={this.props.categoriasUrl} />
                </div>
                <figcaption>
                    <h4>
                        <a href={this.props.categoriasUrl}>
                            {this.props.colecao.nome}
                        </a>
                    </h4>
                </figcaption>
            </figure>
        )
    }
});


BlockColecoes = React.createClass({

    render : function () {

        return (
            <div className="col-sm-4 col-xs-12">
                <Figure colecao={this.props.colecao} dirImg={this.props.dirImg} categoriasUrl={this.props.categoriasUrl} />
            </div>
        )
    }
});


$(function () {

    var ColecoesList = React.createClass({
        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data: result });
            }.bind(this));
        },
        componentDidMount: function() {
            this.load();
        },
        render: function () {
            return (
                <span>{ this.state.data.map(function (colecao) {

                    var categoriasUrl = "/user/categorias/" + colecao.id + "/" + colecao.nome;

                    return (
                        <div key={colecao.id}>
                            <BlockColecoes colecao={colecao} dirImg={dirImg} categoriasUrl={categoriasUrl}/>
                        </div>
                    )
                }) }</span>
            )
        }

    });

    var source = $("#colecoes").attr("data-source");
    var dirImg = $("#colecoes").attr("data-img");

    ReactDOM.render(
        <div>
            <ColecoesList source={source} dirImg={dirImg} />
        </div>,
        document.getElementById('colecoes')
    );


});