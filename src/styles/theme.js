import { createMuiTheme } from '@material-ui/core/styles'
import colors from './colors.scss'
import fonts from './fonts.scss'

const darkTheme = createMuiTheme({
    palette: {
        primary: { main: colors.firstColor },
        secondary: { main: colors.secondColor },
        tertiary: { main: colors.thirdColor },
        background: {
            default: colors.backgroundFirstColor,
            primary: colors.backgroundFirstColor,
            secondary: colors.backgroundSecondColor,
        },
        text: {
            primary: colors.fontGreyColor2,
            secondary: colors.fontGreyColor1,
        },
        // background: {
        //     default: { main: colors.backgroundFirstColor },
        //     primary: { main: colors.backgroundFirstColor },
        //     secondary: { main: colors.backgroundSecondColor },
        // },
        // text: {
        //     primary: { main: colors.fontGreyColor2 },
        //     secondary: { main: colors.fontGreyColor1 },
        // },
    },
    typography: {
        h1: { fontFamily: fonts.titleFont, fontWeight: 800, fontSize: '26px' },
        h2: { fontFamily: fonts.titleFont, fontWeight: 700, fontSize: '24px' },
        h3: { fontFamily: fonts.titleFont, fontWeight: 700, fontSize: '22px' },
        h4: { fontFamily: fonts.titleFont, fontWeight: 700, fontSize: '20px' },
        h5: { fontFamily: fonts.titleFont, fontWeight: 600, fontSize: '18px' },
        h6: { fontFamily: fonts.titleFont, fontWeight: 600, fontSize: '16px' },
        subtitle1: { fontFamily: fonts.paragraphFont, fontWeight: 700, fontSize: '18px' },
        subtitle2: { fontFamily: fonts.paragraphFont, fontWeight: 600, fontSize: '16px' },
        body1: { fontFamily: fonts.paragraphFont, fontWeight: 600, fontSize: '16px' },
        body2: { fontFamily: fonts.paragraphFont, fontWeight: 400, fontSize: '16px' },
        button: { fontFamily: fonts.titleFont, fontWeight: 800 },
    },
})

export default darkTheme;