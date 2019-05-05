<template>
    <div v-bind:class="divClass">
        <a v-bind:href="href" v-bind:target="target" style="width: 100%">
            <button v-bind:type="type" v-bind:formaction="formaction"/>
            <i v-bind:class="buttonClass"></i>
            <slot/>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            icon: {
                default: null
            },
            href: String,
            type: String,
            formaction: String,
            target: String
        },
        computed: {
            divClass: function() {
                return "iconbutton" + (this.icon ? " hasicon" : "");
            },
            buttonClass: function() {
                return (this.icon || "");
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>
    .iconbutton {
        position: relative;
        display: inline-block;
        border-radius: 50px;
    }
    .iconbutton:not(:last-child) {
        margin-right: 30px;
    }
    .iconbutton.hasicon i {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        background-color: #FECE00;
        border-radius: 100%;
        text-align: center;
        color: black;
        filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
        -webkit-filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
        font-style: normal;
        font-size: 28px;
        width: 55px;
        height: 55px;
        line-height: 55px;
    }
    .iconbutton a {
        font-family: 'Varela Round', sans-serif;
        box-sizing: border-box;
        background-color: #020852;
        color: white;
        border-radius: 50px;
        font-style: italic;
        cursor: pointer;
        vertical-align: middle;
        text-decoration: none;
        border: none;
        white-space: normal;
        cursor: pointer;
        text-align: center;
        min-width: 210px;
        max-width: 210px;
        min-height: 45px;
        text-transform: none;
        line-height: 18px;
        font-size: 18px;
        padding: 4px 10px;
        position: relative !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .iconbutton a:hover {
        opacity: 0.8;
    }
    .iconbutton.hasicon a {
        padding-left: 65px;
        padding-right: 30px;
        margin: 5px 0;
    }
    .iconbutton button {
        position: absolute;
        right: 0;
        background: none;
        border: none;
        width: 100%;
        height: 45px;
        border-radius: 50px;
    }
</style>
