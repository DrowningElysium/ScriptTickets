<script setup lang="ts">
import SellCard from "./SellCard.vue";
</script>

<template>
    <div class="align-self-center px-4 py-5 px-md-5 text-center text-lg-start mt-auto mb-auto">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <SellCard />

                <div class="col-lg-6 mb-5 mb-md-0">
                    <div class="card">
                        <div
                            class="card-body px-4 px-xl-5"
                            style="padding: 2.5rem"
                        >
                            <div class="card-title mb-4">
                                <h1><slot name="title"></slot></h1>
                            </div>

                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
