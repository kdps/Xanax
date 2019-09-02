const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const BrotliPlugin = require('brotli-webpack-plugin');

module.exports = {
	plugins: [
		new CompressionPlugin({
			cache: true
		}),
		new BrotliPlugin({
			threshold: 10240,
			minRatio: 0.8
		})
	],
	mode: "production",
	entry: [
		'babel-polyfill', './index.js'
	],
	output: {
		filename: './coreJS.js',
		path: path.resolve(__dirname, 'dist'),
		libraryTarget: "umd"
	},
	target: "web",
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin({
				cache: true,
				sourceMap: true
			}), 
			new UglifyJsPlugin({
				include: /\.js$/,
				uglifyOptions: {
					parallel: true,
					mangle: true,
					minimize: true,
					compress: true,
					toplevel: true,
                    screw_ie8: true
				}
			}),
		],
		nodeEnv: 'production',
		namedModules: false,
		namedChunks: false,
		removeEmptyChunks: true,
		mergeDuplicateChunks: true,
		flagIncludedChunks: false,
		occurrenceOrder: true,
		concatenateModules: true,
		sideEffects: true,
		moduleIds: 'hashed',
		usedExports: true,
		providedExports: true,
		occurrenceOrder: true,
		splitChunks: {
			chunks: 'async',
			minSize: 30000,
			maxSize: 0,
			minChunks: 1,
			maxAsyncRequests: 5,
			maxInitialRequests: 3,
			automaticNameDelimiter: '~',
			name: true,
			cacheGroups: {
				vendors: {
					test: /[\\/]node_modules[\\/]/,
					priority: -10
				}, 
				default: {
					minChunks: 2,
					priority: -20,
					reuseExistingChunk: true
				}
			}
		}
	},
	name: 'coreJS',
	cache: true,
	amd: {
		jQuery: true
	},
	target: "web",
	performance: {
		hints: 'error',
		maxEntrypointSize: 4000000,
		maxAssetSize: 1000000
	},
	module: {
		rules: [{
			test: /\.js$/,
			exclude: /node_modules/,
			use: {
				loader: 'babel-loader',
				options: {
					presets: ['@babel/preset-env']
					//,plugins: ['@babel/plugin-transform-runtime']
				}
			}
		}, {
			test: /\.css$/,
			use: ['style-loader', 'css-loader']
		}],
		exprContextCritical: false,
		exprContextRecursive: true,
		exprContextRegExp: true,
		exprContextRequest: '.',
		unknownContextCritical: false,
		unknownContextRecursive: false,
		unknownContextRegExp: false,
		unknownContextRequest: '.',
		wrappedContextCritical: true,
		wrappedContextRecursive: true,
		wrappedContextRegExp: /.*/,
		strictExportPresence: true // since webpack 2.3.0
	}
};
