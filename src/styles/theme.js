import { createMuiTheme } from '@material-ui/core/styles'
import colors from './colors.scss'
import fonts from './fonts.scss'

const darkTheme = createMuiTheme({
    palette: {
        primary: { main: colors.firstColor },
        secondary: { main: colors.secondColor },
        tertiary: { main: colors.thirdColor, light: `${colors.thirdColor}cc` },
        background: {
            default: colors.backgroundFirstColor,
            primary: colors.backgroundFirstColor,
            secondary: colors.backgroundSecondColor,
        },
        text: {
            primary: colors.fontGreyColor2,
            secondary: colors.fontGreyColor1,
        },
    },
    typography: {
        h1: { fontFamily: fonts.titleFont, fontWeight: 800, fontSize: '40px' },
        h2: { fontFamily: fonts.titleFont, fontWeight: 700 },
        h3: { fontFamily: fonts.titleFont, fontWeight: 700 },
        h4: { fontFamily: fonts.titleFont, fontWeight: 700 },
        h5: { fontFamily: fonts.titleFont, fontWeight: 600 },
        h6: { fontFamily: fonts.titleFont, fontWeight: 600 },
        subtitle1: { fontFamily: fonts.paragraphFont, fontWeight: 700, fontSize: '18px' },
        subtitle2: { fontFamily: fonts.paragraphFont, fontWeight: 600, fontSize: '18px' },
        body1: { fontFamily: fonts.paragraphFont, fontWeight: 600, fontSize: '18px' },
        body2: { fontFamily: fonts.paragraphFont, fontWeight: 400, fontSize: '16px' },
        button: { fontFamily: fonts.titleFont, fontWeight: 800 },
    },
})

export default darkTheme
