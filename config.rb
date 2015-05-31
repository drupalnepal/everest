# https://github.com/Compass/compass/tree/master/import-once
require 'compass/import-once/activate'

# Require any additional compass plugins installed on your system.
require 'compass-normalize'
require 'breakpoint'
require 'susy'
require 'sass-globbing'
require 'rgbapng'

# http://compass-style.org/help/documentation/configuration-reference/
http_path = "/"
css_dir = "css"
sass_dir = "scss"
images_dir = "images"
javascripts_dir = "js"

# The output style for the compiled css.
# One of: :nested, :expanded, :compact, or :compressed.
output_style = (environment == :production) ? :compressed : :expanded

# Indicates whether the compass helper functions should generate 
# relative urls from the generated css to assets, or absolute urls 
# using the http path for that asset type.
relative_assets = true

# Indicates whether line comments should be added to compiled css 
# that says where the selectors were defined. Defaults to false 
# in production mode, true in development mode.
line_comments = (environment == :production) ? false : true
