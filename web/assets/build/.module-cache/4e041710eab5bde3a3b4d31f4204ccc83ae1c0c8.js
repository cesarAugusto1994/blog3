/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    console.log(result);

    var ColecoesList = React.createClass({displayName: "ColecoesList",

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data: result });
            }.bind(this))
        },

    });

    var source = $("#colecoes").attr("data-source");

    ReactDOM.render(
        React.createElement("div", null, 
            React.createElement(ColecoesList, {source: source})
        ),
        document.getElementById('colecoes')
    );

});