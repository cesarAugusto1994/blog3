/**
 * Created by cesar on 25/01/17.
 */


class Container extends React.Component {

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
        );
    }

}
;

const Render = React.createClass({

    getInitialState: function () {
        return {data: [], categorias: [], tons: []};
    },

    load: function () {
        $.get('/user/categorias', function (result) {
            this.setState({categorias: result});
        }.bind(this));

        $.get('/user/tonalidades', function (result) {
            this.setState({tons: result})
        }.bind(this));

    },

    componentDidMount: function () {
        this.load();
    },

    handleSubmit: function (e) {

        e.preventDefault();

        this.loadBeforeSubmit();

        let nome = this.refs.nome.value.trim();
        let colecao = this.refs.colecao.value.trim();

        if (!nome || !colecao) {
            alertify.error("O Nome da Categoria e a colecao devem ser informadas.");
        }

        const _this = this;

        $.ajax({
            type: "POST",
            url: "/user/categoria/adicionar",
            data: {
                nome: nome,
                colecao: colecao
            },
            cache: false,
            success: function (data) {
                alertify.success(data.message);
                window.location.href = '/user/categorias/' + _this.state.colecao.id + '/' + _this.state.colecao.nome;
                unblock_screen();
            },
            error: function (data) {
                unblock_screen();
                alertify.error("Ocorreu um erro.");
            }
        });
    },

    render: function () {

        const _this = this;

        return (
            <Container>
                <form className="form-horizontal" method="POST" action="{{ path('save_musica') }}">
                    <label className="label text-black">Titulo</label>
                    <p className="control">
                        <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" name="nome" id="nome" required/>
                    </p>
                    <label className="label text-black">N&uacute;mero:</label>
                    <p className="control">
                        <input className="input" type="text" placeholder="N&uacute;mero" name="numero" id="numero" required="required"/>
                    </p>
                    <label className="label text-black">Tonalidade</label>
                    <div className="select is-fullwidth">
                        <select name="tonalidade" ref="tonalidade" id="tonalidade">
                            {this.state.tons.map(function (tom) {
                                return (
                                    <option key={tom} defaultValue={tom}>{tom}</option>
                                )
                            })}
                        </select>
                    </div>
                    <label className="label text-black">Categoria</label>
                    <div className="select is-fullwidth">
                        <select id="categoria" name="categoria" required>
                            {this.state.categorias.map(function (colecao) {
                                return (
                                    <span>
                                        {colecao.colecoes.map(function (categoria) {
                                            return (
                                                <option key={categoria.id} defaultValue={categoria.nome}>{categoria.nome}</option>
                                            )
                                        })}
                                    </span>
                                )
                            })}
                        </select>
                    </div>
                    <br/>
                    <br/>
                    <p className="control">
                        <button className="button is-danger is-fullwidth" type="submit">Salvar</button>
                    </p>
                </form>
            </Container>
        )
    }
});

if (document.getElementById("musica-adicionar")) {

    const categoria = $("#musica-adicionar").data("categoria");

    ReactDOM.render(<div><Render categoria={categoria}/></div>, document.getElementById('musica-adicionar'));
}