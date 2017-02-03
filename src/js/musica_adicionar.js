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
        return {data: [], categorias: [], categoria: [], tons: []};
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
                categoria: categoria,
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

        return (
            <Container>
                <form className="form-horizontal" method="POST" onSubmit={this.handleSubmit}>
                    <label className="label text-black">Titulo</label>
                    <p className="control">
                        <input className="input" type="text" autoFocus="autoFocus" placeholder="Titulo" ref="nome" name="nome" id="nome" required/>
                    </p>
                    <label className="label text-black">N&uacute;mero:</label>
                    <p className="control">
                        <input className="input" type="text" placeholder="N&uacute;mero" ref="numero" name="numero" id="numero"/>
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
                        <select id="categoria" name="categoria" ref="categoria" defaultValue={this.props.categoria} required>
                            {this.state.categorias.map(function (colecao) {
                                return (
                                    <optgroup label={colecao.nome}>
                                        {colecao.categorias.map(function (categoria) {
                                            return (
                                                <option key={categoria.id} value={categoria.id}>{categoria.nome}</option>
                                            )
                                        })}
                                    </optgroup>
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

    ReactDOM.render(<Render categoria={categoria}/>, document.getElementById('musica-adicionar'));
}