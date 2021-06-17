const redirect = (step) => {
    console.log(step)
    window.location.href = `../${step}`;
}
const logout = () => {
    sessionStorage.clear();
    window.location.replace("../")
}