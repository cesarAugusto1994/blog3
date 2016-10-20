/**
 * Created by cesar on 20/10/16.
 */

$(function () {

    var ColecoesList = React.createClass({displayName: "ColecoesList",

        load : function () {
            $.get(this.props.source, function (result) {
                this.setState({ data: result });
            }.bind(this));

            console.log(this.props.source);
        },
        
        render: function () {
            return (
                React.createElement("span", null, "Gol")
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