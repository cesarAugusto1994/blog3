
const styleCard = {width: '100%', minWidth: '150px'};
const styleCardLetra = {backgroundColor: 'transparent', border: 'none',};

const VIEW = React.createClass({

    getInitialState : function () {
        return {
            data : []
        }
    },

    load : function () {

        $.get(this.props.source, function (result) {
            this.setState({data:result})
        }.bind(this))

    },

    componentDidMount : function () {
        this.load();
    },

    render : function () {
        return (
            <Base>
                <Card>
                    <h2>{this.state.data.nome}</h2>
                    <FontControl />
                    <pre id="content-view" style={styleCardLetra} data-key={this.state.data.tom}>{this.state.data.letra}</pre>
                </Card>
            </Base>
        )
    }

});

class FontControl extends React.Component {

    render() {
        return (
            <div className="control is-grouped" id="fontlinks">
                <p className="control has-addon">
                    <button id="incfont" className="button is-light is-small buttonfont">
                        A+
                    </button>
                </p>
                <p className="control">
                    <button id="decfont" className="button is-light is-small buttonfont">
                        A-
                    </button>
                </p>
            </div>
        )
    }
}

class Card extends React.Component {

    render() {
        return (
            <div>
                <div className="card wow fadeInUp animated slide" data-wow-delay=".3s" style={styleCard}>
                    <div className="card-content">
                        <div className="media">
                            <div className="media-content">
                                {this.props.children}
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        )
    }
}
;

class Base extends React.Component {
    render() {
        return (
            <article>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            {this.props.children}
                        </div>
                    </div>
                </div>
            </article>
        )
    }
}

if (document.getElementById("view")) {

    const MUSICA_SOURCE = $("#view").data("praise");

    ReactDOM.render(<VIEW source={MUSICA_SOURCE}/>, document.getElementById("view"));

    $('#incfont').click(function () {
        curSize = parseInt($('#content-view').css('font-size')) + 2;
        curSize2 = parseInt($('.c').css('font-size')) + 2;
        if (curSize <= 32)
            $('#content').css('font-size', curSize);
        if (curSize2 <= 32)
            $('.c').css('font-size', curSize2);
    });
    $('#decfont').click(function () {
        curSize = parseInt($('#content-view').css('font-size')) - 2;
        curSize2 = parseInt($('.c').css('font-size')) - 2;
        if (curSize >= 5)
            $('#content').css('font-size', curSize);
        if (curSize2 >= 5)
            $('.c').css('font-size', curSize2);
    });

    $('.c').css('font-size', 12);
    $('#content-view').css('font-size', 12);
    $("#content-view").transpose({key: 'C'});

}