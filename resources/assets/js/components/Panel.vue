<template>
    <div v-bind:class="defineColor">
        <div class="panel-heading">
            <div class="h1 text-center m-0">{{ title }}<slot name="title"></slot></div>
            <div class="right" v-if="$slots.header"><slot name="header"></slot></div>
        </div>

        <div v-bind:class="defineBodyClass">
            <slot></slot>
        </div>

        <div class="panel-footer" v-if="$slots.footer">
            <div class="footer"><slot name="footer"></slot></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'color', 'body-class'],
        computed: {
            defineColor: function() {
                return "panel " + (this.color || "panel-default");
            },
            defineBodyClass: function() {
                return "panel-body" + (" " +this.bodyClass || "");
            }
        },
        mounted() {
            var toFocus = document.querySelector('[autofocus]');
            if (toFocus !== null) {
                toFocus.focus();
            }
        }
    }
</script>

<style>
    .panel {
        background-color: #E6E6E6 !important;
        margin-bottom: 15px;
    }

    .panel-heading {
        background-color: inherit !important;
        margin-top: 0;
        font-weight: bold;
        border-bottom: 0;
        padding: 10px 10px 0;
    }

    @media (min-width: 992px) {
        .panel-heading .right {
            position: absolute;
            top: 11px;
            right: 25px;
            width: 100%;
        }
    }

    .panel-body {
        background-color: white;
        margin: 10px;
    }

    .form-horizontal .form-group {
        margin-left: 0;
        margin-right: 0;
    }

    .panel-body .col-md-7, .panel-body .col-md-8, .panel-body .col-md-10, .panel-body .col-md-10-67 {
        padding-right: 0;
    }

    .panel-footer {
        background-color: transparent;
        border: 0;
        padding: 0 10px 10px;
    }

    .col-md-12 .form-group {
        padding: 0 !important;
    }
</style>
