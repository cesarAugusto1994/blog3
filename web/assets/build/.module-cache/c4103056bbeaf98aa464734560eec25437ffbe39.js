/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var ColecoesList = React.createClass({displayName: "ColecoesList",
        getInitialState: function() {
            return {data: []};
        },
        load : function () {
            $.get(this.props.source, function (result) {

                console.log(result);
                
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
                        React.createElement("label", null,  colecao.nome)
                    )
                }) )
            )
        }

    });

    var source = $("#colecoes").attr("data-source");

    alert(source);

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(ColecoesList, {source: source})
        ),
        document.getElementById('colecoes')
    );


});