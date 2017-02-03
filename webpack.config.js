
module.exports = {
    entry: [
        "./src/js/login",
        "./src/js/register",
        "./src/js/template",
        "./src/js/user",
        "./src/js/anexos",
        "./src/js/view",
        "./src/js/categorias",
        "./src/js/colecoes",
        "./src/js/musicas",
        "./src/js/categoria_adicionar",
        "./src/js/musica_adicionar",
    ],
    output: {
        filename: "web/assets/build/bundle.js"
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    presets: ['react']
                }
            }
        ]
    }
};