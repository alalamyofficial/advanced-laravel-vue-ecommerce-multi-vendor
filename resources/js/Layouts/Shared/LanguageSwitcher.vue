<template>
  <div>
    <label for="languageSelector">Language: </label>
    <select id="languageSelector" v-model="selectedLanguage" @change="changeLanguage">
      <option v-for="language in supportedLanguages" :key="language" :value="language">{{ language }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'LanguageSwitcher',
  data() {
    return {
      selectedLanguage: 'en',
      supportedLanguages: ['en', 'fr'], // Add more languages as needed
    };
  },
  methods: {
    changeLanguage() {
      // Update the selected language in Laravel session or cookies
      // Refresh the page or fetch new Inertia data based on the selected language
    },
  },
};
</script>
