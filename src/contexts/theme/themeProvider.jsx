// Utils & config
import React from "react";
import { ThemeProvider } from "@material-ui/styles";
import theme from "../../styles/theme";

const MaterialThemeProvider = (props) => {
  return <ThemeProvider theme={theme}>{props.children}</ThemeProvider>;
};

export default MaterialThemeProvider;
