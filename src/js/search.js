/**
 * Created by cesar on 17/04/17.
 */

$(function () {

    const ContainnerSearch = React.createClass({

        render: function () {

            return (
                <div className="col-lg-2 col-md-4 col-sm-12">
                    <form>
                        <label>test
                            <input type="text"/>
                        </label>
                    </form>
                </div>
            )
        }
    });

    const ContainnerResource = React.createClass({

        render: function () {

            return (
                <div className="col-lg-10 col-md-8 col-sm-12">
                    É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma
                    página
                    quando estiver examinando sua diagramação. A vantagem de usar Lorem Ipsum é que ele tem uma
                    distribuição
                    normal de letras, ao contrário de "Conteúdo aqui, conteúdo aqui", fazendo com que ele tenha uma
                    aparência similar a de um texto legível. Muitos softwares de publicação e editores de páginas na
                    internet agora usam Lorem Ipsum como texto-modelo padrão, e uma rápida busca por 'lorem ipsum'
                    mostra
                    vários websites ainda em sua fase de construção. Várias versões novas surgiram ao longo dos anos,
                    eventualmente por acidente, e às vezes de propósito (injetando humor, e coisas do gênero).
                </div>
            )
        }

    });


    const Containner = React.createClass({

        render: function () {

            return (
                <div>
                    <ContainnerSearch/>
                    <ContainnerResource/>
                </div>
            )

        }

    });


    const Render = React.createClass({

        render: function () {
            return (
                <article>
                    <div className="container">
                        <div className="row">
                            <ContainnerSearch/>
                            <ContainnerResource/>
                        </div>
                    </div>
                </article>
            )
        }
    });

    if (document.getElementById('search')) {
        ReactDOM.render(
            <Render/>,
            document.getElementById('search')
        );
    }

});
