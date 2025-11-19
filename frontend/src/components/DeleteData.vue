<template>
  <!-- Ini adalah modal konfirmasi hapus -->
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="card">
      <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <p class="heading">Hapus Data?</p>
      <p class="description">
        Apakah Anda yakin ingin menghapus data ini?
      </p>
      <div class="buttonContainer">
        <button @click="$emit('confirm')" class="acceptButton">Hapus</button>
        <button @click="$emit('close')" class="declineButton">Batal</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .card {
    width: 300px;
    height: 220px;
    width: 320px;
    height: auto;
    background-color: rgb(255, 255, 255);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px 30px;
    gap: 13px;
    position: relative;
    overflow: hidden;
    box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.062);
    box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
  }

  #cookieSvg {
    width: 50px;
  }

  #cookieSvg g path {
    fill: rgb(97, 81, 81);
  }

  .heading {
    font-size: 1.2em;
    font-size: 1.5em;
    font-weight: 800;
    color: rgb(26, 26, 26);
  }

  .description {
    text-align: center;
    font-size: 0.7em;
    font-weight: 600;
    font-size: 0.9em;
    font-weight: 400;
    color: rgb(99, 99, 99);
  }

  .buttonContainer {
    display: flex;
    gap: 20px;
    flex-direction: row;
    margin-top: 10px;
  }

  .acceptButton {
    width: 80px;
    height: 30px;
    background-color: #7b57ff;
    width: 100px;
    height: 40px;
    background-color: #ef4444;
    transition-duration: .2s;
    border: none;
    color: rgb(241, 241, 241);
  }

  .declineButton {
    width: 80px;
    height: 30px;
    width: 100px;
    height: 40px;
    background-color: rgb(218, 218, 218);
    transition-duration: .2s;
    color: rgb(46, 46, 46);
  }

  .acceptButton:hover {
    background-color: #9173ff;
    background-color: #dc2626;
    transition-duration: .2s;
  }

  .fixed {
    position: fixed;
  }
  .inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }
  .z-50 {
    z-index: 50;
  }
  .flex {
    display: flex;
  }
  .items-center {
    align-items: center;
  }
  .justify-center {
    justify-content: center;
  }
  .bg-black {
    background-color: #000;
  }
  .bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
  }
</style>

<script>
import { ref } from "vue";

</script>
<script setup>
defineEmits(['confirm', 'close']);
</script>