# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Added the following to the blacklist:
	- post_meta
	- post_tag_relationships
	- language_relationships
	- term_language_relationships
	- term_translations_relationship

## [3.1.0] - 2019-02-04
### Changed
- Changed this plugin to mu-plugin so that it gets loaded early enough and is also working in network admin

### Added
- This changelog
- More default groups to blacklist (some taken from Redis Object Cache Drop-In): `blog-details`, `blog-id-cache`, `blog-lookup`, `global-posts`, `networks`, `rss`, `sites`, `site-details`, `site-lookup`, `site-options`, `site-transient`, `users`, `useremail`, `userlogins`, `usermeta`, `user_meta`, `userslugs`, `terms`, `plugins`, `counts`, `comment`, `dymoloader1.0`, `stateless_post_meta`, `pll_count_posts`, `the_seo_framework`
- Installation instructions
