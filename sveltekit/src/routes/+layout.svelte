<script>
  import Header from "$lib/components/Header.svelte";
  import Footer from "$lib/components/Footer.svelte";
  import '$lib/global.scss'

  let { children } = $props()
</script>

<svelte:head>
  <title>Hem</title>
</svelte:head>

<Header />

{@render children()}

<Footer />