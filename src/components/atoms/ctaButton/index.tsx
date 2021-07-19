import React from 'react';
import { makeStyles, createStyles, Theme } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';

const useStyles = makeStyles((theme: Theme) =>
  createStyles({

  }),
);

type CtaButtonProps = {
  text: string,
  handleClick: () => void,
}

const CtaButton = (props: CtaButtonProps) => {
  const classes = useStyles();

  return (
    <Button variant="contained" color="primary" size='large' onClick={props.handleClick}>
      {props.text}
    </Button>
  );
}

export default CtaButton;