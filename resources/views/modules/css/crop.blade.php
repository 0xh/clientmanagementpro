<style>
.crop {
    position: relative;
    width: 399.5px;
    height: 200px;
    overflow: hidden;
}

.crop img {
    position: absolute;
    left: 50%;
    top: 50%;
    height: 100%;
    width: auto;
    -webkit-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
            transform: translate(-50%,-50%);
}
.crop img.portrait{
    width: 100%;
    height: auto;
}
</style>