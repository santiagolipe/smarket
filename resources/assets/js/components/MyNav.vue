<template>
    <nav v-bind:class="mynavClass">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand mynav-logo" v-bind:href="href">
                <img v-bind:src="img" v-bind:alt="defineAlt" />
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="hamburg" v-if="!!$slots.default">
            <label for="hamburg">
                <button id="hamburg" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                MENU
            </label>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right items">
              <slot></slot>
          </ul>
        </div><!-- /.navbar-collapse -->
        <div class="right" v-if="!!$slots.right">
            <slot name="right"></slot>
        </div>
      </div><!-- /.container-fluid -->
    </nav>
</template>

<script>
    export default {
        props: ['img', 'alt', 'href'],
        computed: {
            mynavClass: function() {
                return "navbar mynav title" + (!!this.$slots.default ? " hasitems" : "")
                + (!!this.$slots.right ? " hasright" : "");
            },
            defineAlt: function() {
                return this.alt || "Smarket";
            }
        }
    }
</script>

<style>
.mynav .container-fluid {
    padding-top: 10px;
    padding-bottom: 10px;
}
.mynav.hasright .navbar-header,
.mynav.hasright .navbar-collapse {
    padding-right: 90px;
}
    .mynav .container-fluid .right {
        position: absolute;
        top: 20px;
        right: 25px;
    }
.navbar-toggle {
    margin-right: 0;
}
.navbar-toggle .icon-bar {
    background-color: #fff;
}
    .title::before,
    .title::after {
        position: absolute;
        content:"";
        width:100%;
        height:10px;
        -moz-transition: width 0.85s ease;
        -webkit-transition: width 0.85s ease;
        -ms-transition: width 0.85s ease;
        transition: width 0.85s ease;
        -moz-transition-delay: 0.5s;
        -webkit-transition-delay: 0.5s;
        -ms-transition-delay: 0.5s;
        transition-delay: 0.5s;
    }

    body.is-loading .title::before,
    body.is-loading .title::after {
        width: 0;
    }

    .title:before {
        background-image: linear-gradient(to right, #FECE00 0%, transparent 100%);
        transform: translateY(-10px);
        left: 0;
    }

    .title::after {
        background-image: linear-gradient(to left, #020852 0%, transparent 100%);
        right: 0;
    }

    .mynav {
        margin-bottom: 100px;
    }
    .title {
        -moz-transition: -moz-transform 0.5s ease,opacity 0.5s ease;
        -webkit-transition: -webkit-transform 0.5s ease,opacity 0.5s ease;
        -ms-transition: -ms-transform 0.5s ease,opacity 0.5s ease;
        transition: transform 0.5s ease,opacity 0.5s ease;
        opacity: 1;
        padding-top: 10px;
        border: none;
    }

    body.is-loading .title,
    body.is-loading .mynav-logo img {
        opacity: 0;
    }

    .mynav .container-fluid {
        position: relative;
        background-color: rgba(255, 255, 255, 0.7);
    }

    .mynav:not(.hasitems) .container-fluid {
        max-height: 130px;
    }

    .title .items {
        height: 100%;
        display: flex;
        align-items: center;
        padding-right: 10px;
        line-height: 130px;
    }

    .title.small .items {
        line-height: 75px;
    }

    .title.right-items .items {
        float: right;
    }

    .mynav .navbar-brand {
        padding: 0;
    }

    .mynav-logo img {
        max-width: 100%;
        max-height: 130px;
        -moz-transition: opacity 0.5s ease;
        -webkit-transition: opacity 0.5s ease;
        -ms-transition: opacity 0.5s ease;
        transition: opacity 0.5s ease;
    }

    .mynav.small .navbar-brand,
    .mynav.small img {
        height: 75px;
    }

    .mynav.small {
        padding-top: 25px;
        margin-bottom: 25px;
    }

    .title.small .container-fluid {
        height: fit-content;
    }

    .navbar.center {
        text-align: center;
    }

    .navbar-header {
        height: 130px;
    }

    .navbar.small .navbar-header {
        height: 75px;
    }

    .navbar.center .navbar-brand img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .mynav .hamburg label {
        display: none;
    }

    @media (max-width: 1299px) {
        .mynav.hasright .navbar-collapse {
            padding-right: 15px;
        }

        .mynav.hasright .navbar-header {
            padding-right: 70px;
        }
        .mynav .container-fluid .right {
            right: 15px;
        }

        .mynav {
            text-align: center;
        }

        .mynav.hasitems {
            margin-bottom: 0 !important;
        }

        .mynav .container-fluid {
            padding-bottom: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .container-fluid > .navbar-header,
        .container-fluid > .navbar-collapse {
            margin: 0;
        }

        .navbar-brand,
        .navbar-toggle {
            float: none;
        }

        .navbar:not(.center) .navbar-brand {
            position: relative;
            display: block;
        }

        .navbar-brand img {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .mynav .hamburg {
            background-color: #020852;
            text-align: center;
            margin-top: 10px;
            color: white;
            font-size: 28px;
            font-style: italic;
            font-weight: bold;
            line-height: 1;
        }

        .mynav .hamburg label {
            display: block;
            margin-bottom: 0;
            cursor: pointer;
        }
        .mynav .hamburg label::before {
            padding: 0;
        }

        .mynav .navbar-toggle {
            border: none;
            margin: 0;
            border-radius: 0;
        }

        .mynav .navbar-toggle .icon-bar {
            width: 33px;
            height: 4px;
        }

        .mynav.hasitems::after {
            display: none;
        }
    }

    @media (min-width: 433px) {
        .mynav.hasright .navbar-header {
            padding-right: 0;
        }
    }

    @media (max-width:991px) and (min-height:415px) {
        .mynav {
            margin-bottom: 50px;
        }
    }

    @media (max-height: 414px) {
        .mynav {
            margin-bottom: 50px;
        }
    }
</style>
