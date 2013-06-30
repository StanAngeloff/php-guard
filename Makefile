BIN_PATH := bin

.PHONY: default install-composer install-development install clean

# Do nothing if `make` invoked with no arguments.
default:
	@/bin/echo "No default '$(MAKE)' target configured. Did you mean any of the following:"
	@/bin/echo
	@cat '$(firstword $(MAKEFILE_LIST))' | grep '^[[:alnum:] \-]\+:' | sed -e 's/:.*//g' | sort -u | tr "\\n" ' ' | fold -sw 76 | sed -e 's#^#    #g'
	@/bin/echo
	@exit 1

# Check if a given command is available and exit if it's missing.
required-dependency = \
	/bin/echo -n "Checking if '$(1)' is available... " ; \
	$(eval COMMAND := which '$(1)') \
	if $(COMMAND) >/dev/null; then \
		$(COMMAND) ; \
	else \
		/bin/echo "command failed:" ; \
		/bin/echo ; \
		/bin/echo "    $$ $(COMMAND)" ; \
		/bin/echo ; \
		/bin/echo "You must install $(2) before you could continue." ; \
		/bin/echo "On Debian-based systems, you may want to try:" ; \
		/bin/echo ; \
		/bin/echo "    $$ [sudo] apt-get install $(3)" ; \
		/bin/echo ; \
		exit 1; \
	fi

COMPOSER_BINARY := $(BIN_PATH)/composer.phar
install-composer: $(COMPOSER_BINARY)
$(COMPOSER_BINARY):
	@$(call required-dependency,php,PHP,php5-cli)
	@mkdir -p "$(shell dirname "$(COMPOSER_BINARY)")"
	@php -d 'allow_url_fopen=On' -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));" -- --install-dir="$(shell dirname "$(COMPOSER_BINARY)")"

# Bootstrap a development environment.
install-development: install-composer

install: install-development

clean:
	@$(call required-dependency,git,Git,git-core)
	@git clean -dfx


# vim: ts=4 sw=4 noet
