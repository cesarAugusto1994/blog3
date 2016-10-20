/**
 * Created by cesar on 20/10/16.
 */


Image = React.createClass({displayName: "Image",
    render : function () {
        return (
            React.createElement("a", {href: "#"}, 
                React.createElement("img", {className: "img-responsive", value: "min-height: 160px; max-height: 160px; margin: auto;", src: this.props.colecao.imagem, alt: this.props.colecao.name})
            )
        )
    }
});


Figure = React.createClass({displayName: "Figure",

    render : function () {
        return (
            React.createElement("figure", {className: "wow fadeInLeft animated portfolio-item", "data-wow-duration": "500ms", "data-wow-delay": "0ms"}, 
                React.createElement("div", {className: "img-wrapper"}, 
                    React.createElement(Image, {colecao: this.props.colecao})
                ), 
                React.createElement("figcaption", null, 
                    React.createElement("h4", null, 
                        React.createElement("a", {href: "#"}, 
                            this.props.colecao.nome
                        )
                    )
                )
            )
        )
    }
});


BlockColecoes = React.createClass({displayName: "BlockColecoes",

    render : function () {

        return (
            React.createElement("div", {className: "col-sm-4 col-xs-12"}, 
                React.createElement(Figure, {colecao: this.props.colecao})
            )
        )
    }
});


$(function () {

    var ColecoesList = React.createClass({displayName: "ColecoesList",
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
                React.createElement("span", null,  this.state.data.map(function (colecao) {
                    return (
                        React.createElement("div", {key: colecao.id}, 
                            React.createElement(BlockColecoes, {colecao: colecao})
                        )
                    )
                }) )
            )
        }

    });

    var source = $("#colecoes").attr("data-source");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(ColecoesList, {source: source})
        ),
        document.getElementById('colecoes')
    );


});