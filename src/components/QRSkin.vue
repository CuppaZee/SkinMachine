<template>
    <!-- <div>{{skin}}</div> -->
    <canvas ref="canv" height="300" width="300"></canvas>
</template>

<script>
import lf from "localforage"
import QRCode from "qrcode";
import { saveAs } from "file-saver";
import axios from "axios";
import skins from "assets/Skins.json";

function createImg(url) {
    var img = new Image()
    var prom = new Promise(function(resolve, reject) {
        img.onload = function () {
            resolve(img);
        };
    })
    img.src = url;
    return prom;
}

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
            var x, skinData, img, skin;
            if ((this.skin||1).toString().startsWith('template:')) {
                var imgURL = this.skin.split('|').slice(1).join('|');
                console.log(imgURL);
                var template = this.skin.split('|')[0].split(':')[1];
                var imgData = await axios
                        .get(
                            imgURL,
                            {
                                responseType: "arraybuffer"
                            }
                        )
                        .then(
                            response =>
                                `data:image/${imgURL.match(/\.([^./]+)$/)[1]};base64,${new Buffer.from(
                                    response.data,
                                    "binary"
                                ).toString("base64")}`
                        );
                img = await createImg(imgData);
                skin = { height: 250, width: { minizee: 250, rum: 500 }[template] }
                canvas.height = skin.height;
                canvas.width = skin.width;
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                if (template=='minizee') {
                    let amt = 5;
                    for (x = 0; x < amt; x++) {
                        for (var y = 0; y < amt; y++) {
                            if (!(x!=0&&x!=(amt-1)&&y!=0&&y!=(amt-1))) ctx.drawImage(img, x*(250/amt)+2, y*(250/amt)+2, (250/amt)-4, (250/amt)-4);
                        }
                    }
                    ctx.fillStyle = "#ffffff44";
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                } else if (template=='rum') {
                    ctx.drawImage(img, 8, 8, 234, 234);
                }
                this.qrcode = await QRCode.toDataURL(
                    this.url?`https://www.munzee.com/m/${this.url[0]}/${this.url[1]}/${this.url[2]}/`:"https://www.munzee.com/m/sohcah/1363/2K8LP4/",
                    {
                        width: { minizee: 142, rum: 234 }[template],
                        margin: 0,
                        color: {
                            dark: "#000000ff",
                            light: "#00000000"
                        }
                    }
                );
                var qr = await createImg(this.qrcode);
                ctx.drawImage(
                    qr,
                    { minizee: 54, rum: 258 + 24 }[template],
                    { minizee: 54, rum: 32 }[template],
                    { minizee: 142, rum: 234 - 48 }[template],
                    { minizee: 142, rum: 234 - 48 }[template]
                );
                ctx.textAlign = 'left';
                ctx.font = "bold 20px Roboto";
                var size = ctx.measureText(`${(this.url||['sohcah', 1363])[1]}`);
                ctx.fillStyle="white"
                ctx.fillRect({ minizee: 54, rum: 258 + 24 }[template] + 2, { minizee: 54, rum: 32 }[template] + { minizee: 142, rum: 234 - 48 }[template]+2, size.width+4, 20)
                ctx.fillStyle = "black";
                ctx.fillText(`${(this.url||['sohcah', 1363])[1]}`, { minizee: 54, rum: 258 + 24 }[template], { minizee: 54, rum: 32 }[template] + { minizee: 142, rum: 234 - 48 }[template] + 18);
            } else {
                if ((this.skin||1).toString().startsWith('custom:')) {
                    x = await lf.getItem((this.skin||1).toString());

                    skinData = x.Data;
                } else {
                    x = skins.find(i=>i.SkinID==(this.skin||1));

                    skinData = await axios
                        .get(
                            `/statics/Skins/${x.SkinOwner.toLowerCase()}/${x.FileName}_ex.${x.FileExt}`,
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
                }
                skin = await createImg(skinData);
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
                img = await createImg(this.qrcode);
                ctx.drawImage(
                    img,
                    x.QROffsetX || 0,
                    x.QROffsetY || 0,
                    x.QRSize,
                    x.QRSize
                );
                ctx.textAlign = 'left';
                ctx.fillStyle = "black";
                ctx.font = "30px Roboto";
                ctx.fillText(`${(this.url||['sohcah', 1363])[1]}`, x.QROffsetX, x.QROffsetY + x.QRSize + 30);
                if (x.DeployedBy) {
                    ctx.font = `${x.DeployedBySize*1.5}px Roboto`;
                    if (x.DeployedByCentered) {
                        ctx.textAlign = 'center';
                        ctx.fillText(`${(this.url||['sohcah', 1363])[0]}`, x.DeployedByX+(x.DeployedByWidth/2), x.DeployedByY-((x.DeployedBySize*1.5)/2));
                    } else {
                        ctx.fillText(`${(this.url||['sohcah', 1363])[0]}`, x.DeployedByX, x.DeployedByY);
                    }
                }
            }
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
