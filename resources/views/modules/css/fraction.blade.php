<style>
.math-box {
  display: inline-block;
}
.math-box .vstack {
  display: inline-block;
  position: relative;
}
.math-box .vstack > div {
  position: relative;
  text-align: center;
  height: 0;
}
.math-box .baseline-fix {
  display: inline-table;
  table-layout: fixed;
}
.math-box .frac-line {
  width: 100%;
  color: #81d4fa;
  display: inline-block;
}
.math-box .frac-line:before {
  display: block;
  border-bottom-style: solid;
  border-bottom-width: 1px;
  content: "";
}
.math-box .frac-line:after {
  display: block;
  margin-top: -1px;
  border-bottom-style: solid;
  border-bottom-width: 0.04em;
  content: "";
}
.math-box .strut {
  display: inline-block; 
}
</style>