
module.exports = {
    entry: {
        register: "./src/js/register",
        template: "./src/js/template",
        user: "./src/js/user",
        anexos: "./src/js/anexos",
        categorias: "./src/js/categorias",
        colecoes: "./src/js/colecoes",
        musicas: "./src/js/musicas",
    },
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