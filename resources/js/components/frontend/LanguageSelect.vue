<template>
    <div class="language-select-container">
        <img @click="changeLanguage('en')" :class="[selected_locale === 'en' ? 'active' : '']" width="50px" src="https://lipis.github.io/flag-icon-css/flags/4x3/gb.svg" alt="UK Flag">
        <img @click="changeLanguage('pol')" :class="[selected_locale === 'pol' ? 'active' : '']" width="50px" src="https://lipis.github.io/flag-icon-css/flags/4x3/pl.svg" alt="Poland Flag">
        <img @click="changeLanguage('fra')" :class="[selected_locale === 'fra' ? 'active' : '']" width="50px" src="https://lipis.github.io/flag-icon-css/flags/4x3/fr.svg" alt="France Flag">
    </div>
</template>

<script>
    export default {
        name: "LanguageSelect",
        props: ['fontSizeClass'],
        data() {
          return {
              selected_locale: 'en',
          }
        },
        methods: {
            changeLanguage: function(locale) {
                const self = this;
                self.selected_locale = locale;
                EventBus.$emit('language.select', { locale: locale });
            }
        }
    }
</script>
