<template>
    <div class="modal-backdrop">
      <div class="modal">
        <header class="modal-header">
          <slot name="header">
            title!
          </slot>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </header>
  
        <section class="modal-body">
          <slot name="body">
            body!
          </slot>
         </section>
  
        <footer class="modal-footer">
          <slot name="footer">
            footer!
          </slot>
          <button type="button" class="btn-blue" @click="close">
                Cerrar
          </button>
        </footer>
      </div>
    </div>
  </template>

<script lang="ts">
    export default {
    name: 'Modal',
    methods: {
        close() {
        this.$emit('close');
        },
    },
    };
</script>

<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #3635354d;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    width: 40%;
    max-width: 500px;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-header {
    position: center;
    border-bottom: 1px solid #eeeeee;
    color: #079d46;
    justify-content: space-between;
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
    justify-content: flex-end;
  }

  .modal-body {
    position: center;
    padding: 20px 10px;
  }

  .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #000000;
    background: transparent;
  }

  .btn-green {
    color: white;
    background: #079d46;
    border: 1px solid #079d46;
    border-radius: 2px;
    margin: 3px;
  }
  .btn-blue {
    color: white;
    background: #2170b1;
    border: 1px solid #2170b1;
    border-radius: 2px;
    margin: 3px;
  }
</style>