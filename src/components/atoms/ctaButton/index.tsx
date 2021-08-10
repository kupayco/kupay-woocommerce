import React from 'react';
import { makeStyles, createStyles, Theme } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    button: {
      padding: `${theme.spacing(2)}px ${theme.spacing(6)}px`
    }
  }),
);

type CtaButtonProps = {
  text: string,
  handleClick: () => void,
}

const CtaButton = (props: CtaButtonProps) => {
  const classes = useStyles();

  return (
    <Button variant="contained" color="primary" size='large' onClick={props.handleClick} className={classes.button}>
      {props.text}
    </Button>
  );
}

export default CtaButton;