const req = require.context('@/icons/svg', false, /\.svg$/)
const requireAll = requireContext => requireContext.keys()

const re = /\.\/(.*)\.svg/

const iconList = requireAll(req).map(i => {
    return i.match(re)[1]
})

export default iconList
