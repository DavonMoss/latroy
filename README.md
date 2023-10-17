# latroy
Repository for latroy.net website. This is a personal project to learn the fundamental tech behind hosting and maintaining a web server from scratch. See more detailed write-up at https://latroy.net/notes/.

Personal website implemented with:

- Debian 12 (Linux)
- Apache 2
- MariaDB (MySQL)
- PHP
- jQuery
- Vanilla JS, HTML, and CSS

Running on VPS provided by Vultr. 

Version 1.0.0
- LANDING: landing page, shows site structure and has social links
	- future goals: potentially add more social links
- PHOTOS: page to explore db of images, one click at a time.
	- future goals: upload more images, optimize loading time, kinda slow rn. working on that. see https://github.com/DavonMoss/png_loader 
- NOTES: page to store notes on anything, most likely programming/DSA notes.
	- future goals: populate with useful content
- MUSIC: page to host my music/mixes/any audio stuff.
	- future goals: more content

Future infrastructure goals:
- Want to explore front-end formatting options so that we can get the layout dynamically adjusting on any device. Would prefer to do with the tech I already have, gotta flip through docs and toy around.
- Explore NoSQL options - current MySQL + PHP combo is working fine, just wouldn't hurt to know more about other paradigms, NoSQL/Document db's seem better suited to the style of data retrieval I'm using for the site anyway.
