<template>
    <canvas ref="canv" height="300" width="300"></canvas>
</template>

<script>
import QRCode from "qrcode";
import { saveAs } from "file-saver";
import axios from "axios";
import skins from "assets/Skins.json";

export default {
    name: "QRSkin",
    data() {
        return {
            qrcode: null,
            output: ""
        };
    },
    props: ["skin", "url"],
    watch: {
        skin() {
            this.$nextTick(this.init);
        }
    },
    methods: {
        async init() {
            var canvas = this.$refs.canv;
            var ctx = canvas.getContext("2d");
            var x = skins.find(i=>i.SkinID==(this.skin||1));

            var skinData = await axios
                .get(
                    `/statics/Skins/${x.SkinOwner}/${x.FileName}_ex.${x.FileExt}`,
                    {
                        responseType: "arraybuffer"
                    }
                )
                .then(
                    response =>
                        `data:image/${x.FileExt};base64,${new Buffer.from(
                            response.data,
                            "binary"
                        ).toString("base64")}`
                );
            var skin = new Image();
            skin.src = skinData;
            canvas.height = skin.height;
            canvas.width = skin.width;
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(skin, 0, 0, skin.width, skin.height);
            this.qrcode = await QRCode.toDataURL(
                this.url?`https://www.munzee.com/m/${this.url[0]}/${this.url[1]}/${this.url[2]}/`:"https://www.munzee.com/m/sohcah/1363/2K8LP4/",
                {
                    width: x.QRSize,
                    margin: 0,
                    color: {
                        dark: x.QRColor || "#000000ff",
                        light: "#00000000"
                    }
                }
            );
            var img = new Image();
            img.src = this.qrcode;
            ctx.drawImage(
                img,
                x.QROffsetX || 0,
                x.QROffsetY || 0,
                x.QRSize,
                x.QRSize
            );
            this.output = canvas.toDataURL();
        },
        save() {
            var d = new Date(Date.now());
            saveAs(
                this.output,
                `${d.getFullYear()}-${
                    d.getMonth() < 9 ? "0" : ""
                }${d.getMonth() + 1}-${
                    d.getDate() < 10 ? "0" : ""
                }${d.getDate()}-${
                    d.getHours() < 10 ? "0" : ""
                }${d.getHours()}:${
                    d.getMinutes() < 10 ? "0" : ""
                }${d.getMinutes()}:${
                    d.getSeconds() < 10 ? "0" : ""
                }${d.getSeconds()}.png`
            );
        }
    },
    updated() {
        this.$nextTick(this.init);
    },
    mounted() {
        this.$nextTick(this.init);
    },
    created() {
        this.$nextTick(this.init);
    },
    activated() {
        this.$nextTick(this.init);
    }
};
</script>
